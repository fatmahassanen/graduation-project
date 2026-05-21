<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * NationalIdService
 *
 * Service for validating and extracting data from Egyptian National IDs
 */
class NationalIdService
{
    /**
     * Egyptian Governorate codes mapping (digits 8-9 of National ID)
     */
    private const GOVERNORATE_CODES = [
        '01' => 'Cairo',
        '02' => 'Alexandria',
        '03' => 'Port Said',
        '04' => 'Suez',
        '11' => 'Damietta',
        '12' => 'Dakahlia',
        '13' => 'Ash Sharqia',
        '14' => 'Kaliobeya',
        '15' => 'Kafr El Sheikh',
        '16' => 'Gharbia',
        '17' => 'Monufia',
        '18' => 'El Beheira',
        '19' => 'Ismailia',
        '21' => 'Giza',
        '22' => 'Beni Suef',
        '23' => 'Fayoum',
        '24' => 'El Menia',
        '25' => 'Assiut',
        '26' => 'Sohag',
        '27' => 'Qena',
        '28' => 'Aswan',
        '29' => 'Luxor',
        '31' => 'Red Sea',
        '32' => 'New Valley',
        '33' => 'Matrouh',
        '34' => 'North Sinai',
        '35' => 'South Sinai',
        '88' => 'Foreign',
    ];

    /**
     * Validate Egyptian National ID format
     */
    public function validate(string $nationalId): bool
    {
        // Must be exactly 14 digits
        if (! preg_match('/^\d{14}$/', $nationalId)) {
            return false;
        }

        // First digit must be 2 (1900s) or 3 (2000s)
        $century = substr($nationalId, 0, 1);
        if (! in_array($century, ['2', '3'])) {
            return false;
        }

        // Validate birth date (digits 2-7)
        $birthDate = $this->extractBirthDate($nationalId);
        if (! $birthDate) {
            return false;
        }

        // Validate governorate code (digits 8-9)
        $governorateCode = substr($nationalId, 7, 2);
        if (! isset(self::GOVERNORATE_CODES[$governorateCode])) {
            return false;
        }

        return true;
    }

    /**
     * Extract birth date from National ID
     */
    public function extractBirthDate(string $nationalId): ?Carbon
    {
        if (strlen($nationalId) !== 14) {
            return null;
        }

        try {
            $century = substr($nationalId, 0, 1);
            $year = substr($nationalId, 1, 2);
            $month = substr($nationalId, 3, 2);
            $day = substr($nationalId, 5, 2);

            // Determine full year based on century digit
            $fullYear = ($century === '2' ? '19' : '20').$year;

            // Create Carbon instance
            $date = Carbon::createFromFormat('Y-m-d', "{$fullYear}-{$month}-{$day}");

            // Validate the date is reasonable
            if ($date->isFuture() || $date->year < 1900) {
                return null;
            }

            return $date;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extract governorate from National ID
     */
    public function extractGovernorate(string $nationalId): ?string
    {
        if (strlen($nationalId) !== 14) {
            return null;
        }

        $governorateCode = substr($nationalId, 7, 2);

        return self::GOVERNORATE_CODES[$governorateCode] ?? null;
    }

    /**
     * Extract gender from National ID
     *
     * @return string|null Returns 'male' or 'female'
     */
    public function extractGender(string $nationalId): ?string
    {
        if (strlen($nationalId) !== 14) {
            return null;
        }

        // Digit 10 (index 9) determines gender
        // Odd = Male, Even = Female
        $genderDigit = (int) substr($nationalId, 9, 1);

        return ($genderDigit % 2 === 1) ? 'male' : 'female';
    }

    /**
     * Extract all data from National ID at once
     */
    public function extractAll(string $nationalId): ?array
    {
        if (! $this->validate($nationalId)) {
            return null;
        }

        return [
            'birth_date' => $this->extractBirthDate($nationalId),
            'birth_governorate' => $this->extractGovernorate($nationalId),
            'gender' => $this->extractGender($nationalId),
        ];
    }

    /**
     * Get all governorate codes and names
     */
    public static function getGovernorates(): array
    {
        return self::GOVERNORATE_CODES;
    }

    /**
     * Get list of governorates for dropdown (sorted alphabetically)
     */
    public static function getGovernoratesForDropdown(): array
    {
        $governorates = self::GOVERNORATE_CODES;
        asort($governorates);

        return $governorates;
    }
}
