<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Services\StudentCodeGenerator;
use Illuminate\Http\JsonResponse;

/**
 * API Controller for Admission-related operations.
 *
 * This controller provides RESTful API endpoints for admission management,
 * including automatic student code generation for approved admissions.
 *
 * @package App\Http\Controllers\Api
 */
class AdmissionsApiController extends Controller
{
    /**
     * Generate a unique student code for the specified admission.
     *
     * This endpoint generates an 8-digit student code following the format YYYYNNNN
     * where YYYY is the current academic year and NNNN is a zero-padded sequential number.
     *
     * The method performs the following validations:
     * - Verifies the admission exists in the database
     * - Verifies the admission status is 'pending'
     *
     * Algorithm:
     * 1. Find admission by ID
     * 2. Validate admission exists (return 404 if not found)
     * 3. Validate admission status is 'pending' (return 400 if not)
     * 4. Use StudentCodeGenerator service to generate code
     * 5. Extract year and sequence from generated code
     * 6. Return JSON response with code, year, sequence, and success flag
     *
     * Preconditions:
     * - admissionId is a positive integer
     * - Database connection is active
     * - User is authenticated as admin (enforced by middleware)
     *
     * Postconditions:
     * - Returns JsonResponse with HTTP 200 on success
     * - Returns JsonResponse with HTTP 404 if admission not found
     * - Returns JsonResponse with HTTP 400 if admission is not pending
     * - No database modifications occur
     *
     * @param int $admissionId The ID of the admission record
     * @return JsonResponse JSON response containing the generated code or error message
     *
     * Success Response (200):
     * {
     *   "success": true,
     *   "code": "20260006",
     *   "year": 2026,
     *   "sequence": 6
     * }
     *
     * Not Found Response (404):
     * {
     *   "success": false,
     *   "message": "Admission not found"
     * }
     *
     * Invalid Status Response (400):
     * {
     *   "success": false,
     *   "message": "Admission is not pending"
     * }
     */
    public function generateCode(int $admissionId): JsonResponse
    {
        // Step 1: Find admission by ID
        $admission = Admission::find($admissionId);

        // Step 2: Validate admission exists
        if (! $admission) {
            return response()->json([
                'success' => false,
                'message' => 'Admission not found',
            ], 404);
        }

        // Step 3: Validate admission status is 'pending'
        if ($admission->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Admission is not pending',
            ], 400);
        }

        try {
            // Step 4: Use StudentCodeGenerator service to generate code
            $generator = new StudentCodeGenerator();
            $code = $generator->generate($admissionId);

            // Step 5: Extract year and sequence from generated code
            $year = (int) substr($code, 0, 4);
            $sequence = (int) substr($code, 4, 4);

            // Step 6: Return JSON response with success data
            return response()->json([
                'success' => true,
                'code' => $code,
                'year' => $year,
                'sequence' => $sequence,
            ], 200);
        } catch (\Exception $e) {
            // Handle any unexpected errors gracefully
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate student code: '.$e->getMessage(),
            ], 500);
        }
    }
}
