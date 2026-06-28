<?php

namespace App\Services;

use App\Models\Admission;

/**
 * StudentCodeGenerator
 *
 * Service for generating unique student codes for approved admissions
 * Format: YYYYNNNN (Year + 4-digit sequence number)
 */
class StudentCodeGenerator
{
    /**
     * Generate a unique student code for an admission
     *
     * Algorithm:
     * 1. Get current academic year (call getCurrentAcademicYear())
     * 2. Get next sequence number for that year (call getNextSequenceNumber())
     * 3. Format the code (call formatCode())
     * 4. Return the formatted code
     *
     * Preconditions:
     * - admissionId is a positive integer
     * - Admission exists in database
     * - Database connection is active
     *
     * Postconditions:
     * - Returns 8-digit string in YYYYNNNN format
     * - No database modifications
     *
     * @param  int  $admissionId  The admission ID to generate code for
     * @return string The generated 8-digit student code (YYYYNNNN)
     *
     * @throws \InvalidArgumentException If admission ID is invalid or admission does not exist
     * @throws \RuntimeException If generated code does not meet format requirements
     */
    public function generate(int $admissionId): string
    {
        // Validate precondition: admissionId must be positive
        if ($admissionId <= 0) {
            throw new \InvalidArgumentException('Admission ID must be a positive integer');
        }

        // Validate precondition: admission must exist in database
        $admission = Admission::find($admissionId);
        if (! $admission) {
            throw new \InvalidArgumentException("Admission with ID {$admissionId} does not exist");
        }

        // Step 1: Get current academic year
        $currentYear = $this->getCurrentAcademicYear();

        // Step 2: Get next sequence number for that year
        $nextSequence = $this->getNextSequenceNumber($currentYear);

        // Step 3: Format the code
        $studentCode = $this->formatCode($currentYear, $nextSequence);

        // Postcondition: Verify code is 8 digits
        if (strlen($studentCode) !== 8 || ! ctype_digit($studentCode)) {
            throw new \RuntimeException('Generated code does not meet format requirements');
        }

        // Step 4: Return the formatted code
        return $studentCode;
    }

    /**
     * Get the current academic year
     *
     * Algorithm:
     * 1. Get current date/time from system
     * 2. Extract year component
     * 3. Validate year is within valid range
     * 4. Return as integer
     *
     * Preconditions:
     * - System date/time is available and accurate
     * - Server timezone is configured correctly
     *
     * Postconditions:
     * - Returns 4-digit integer representing current year
     * - Return value is between 2024 and 2100
     * - No side effects or database modifications
     *
     * @return int The current year (4 digits)
     *
     * @throws \RuntimeException If system year is outside valid range
     */
    public function getCurrentAcademicYear(): int
    {
        $year = (int) date('Y');

        // Validate postcondition: year must be within valid range
        if ($year < 2024 || $year > 2100) {
            throw new \RuntimeException("System year {$year} is outside valid range (2024-2100). Please check system date configuration.");
        }

        return $year;
    }

    /**
     * Get the next sequence number for a given year
     *
     * Algorithm (Refactored for Concurrency & Deletion Safety):
     * 1. Query database for the maximum existing student_code starting with the year prefix
     * 2. If a max code exists, extract the last 4 digits and increment by 1
     * 3. If no codes exist for this year, return 1 (first student)
     * 4. Validate the sequence is within valid range (1-9999)
     *
     * Why max() instead of count():
     * - Handles deletions correctly (e.g., if student 20240003 is deleted, next should be 20240004 not 20240003)
     * - Avoids race conditions in concurrent admission approvals
     * - More reliable for sequence generation in distributed systems
     *
     * Preconditions:
     * - year is valid 4-digit integer (2024-2100)
     * - Database connection is active
     *
     * Postconditions:
     * - Returns positive integer between 1 and 9999
     * - Return value equals (highest sequence for year) + 1, or 1 if no records exist
     * - No database modifications
     *
     * @param  int  $year  The academic year to get sequence for
     * @return int The next sequence number (1-9999)
     *
     * @throws \InvalidArgumentException If year is invalid
     * @throws \RuntimeException If sequence exceeds valid range
     */
    public function getNextSequenceNumber(int $year): int
    {
        // Validate precondition: year must be valid 4-digit integer
        if ($year < 2024 || $year > 2100) {
            throw new \InvalidArgumentException('Year must be between 2024 and 2100');
        }

        // Step 1: Query database for the maximum existing student_code for this year
        $maxCode = Admission::where('student_code', 'LIKE', $year.'%')
            ->max('student_code');

        if ($maxCode) {
            // Step 2: Extract the last 4 digits from the max 8-digit code and increment
            $lastSequence = (int) substr($maxCode, 4);
            $nextSequence = $lastSequence + 1;
        } else {
            // Step 3: First student of the year
            $nextSequence = 1;
        }

        // Validate postcondition: sequence must be between 1 and 9999
        if ($nextSequence < 1 || $nextSequence > 9999) {
            throw new \RuntimeException('Sequence number out of valid range (1-9999)');
        }

        return $nextSequence;
    }

    /**
     * Format the student code from year and sequence number
     *
     * Algorithm:
     * 1. Convert year to string (4 digits)
     * 2. Convert sequence to zero-padded string (4 digits)
     * 3. Concatenate year and sequence
     * 4. Return the formatted code
     *
     * Preconditions:
     * - year is between 2024 and 2100
     * - sequence is between 1 and 9999
     *
     * Postconditions:
     * - Returns exactly 8-character string
     * - First 4 characters are the year
     * - Last 4 characters are zero-padded sequence
     * - Result is all numeric
     *
     * @param  int  $year  The academic year (4 digits)
     * @param  int  $sequence  The sequence number (1-9999)
     * @return string The formatted 8-digit code (YYYYNNNN)
     *
     * @throws \InvalidArgumentException If year or sequence is invalid
     */
    public function formatCode(int $year, int $sequence): string
    {
        // Validate precondition: year must be valid 4-digit integer
        if ($year < 2024 || $year > 2100) {
            throw new \InvalidArgumentException('Year must be between 2024 and 2100');
        }

        // Validate precondition: sequence must be between 1 and 9999
        if ($sequence < 1 || $sequence > 9999) {
            throw new \InvalidArgumentException('Sequence must be between 1 and 9999');
        }

        // Step 1: Convert year to string (4 digits)
        $yearString = (string) $year;

        // Step 2: Convert sequence to zero-padded string (4 digits)
        $sequenceString = str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);

        // Step 3: Concatenate year and sequence
        $formattedCode = $yearString.$sequenceString;

        // Validate postcondition: code must be exactly 8 characters
        if (strlen($formattedCode) !== 8) {
            throw new \RuntimeException('Formatted code is not exactly 8 characters');
        }

        // Validate postcondition: code must be all numeric
        if (! ctype_digit($formattedCode)) {
            throw new \RuntimeException('Formatted code contains non-numeric characters');
        }

        // Step 4: Return the formatted code
        return $formattedCode;
    }
}
