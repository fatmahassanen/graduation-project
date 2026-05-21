<?php

use App\Models\Admission;
use App\Services\StudentCodeGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('StudentCodeGenerator', function () {
    describe('getCurrentAcademicYear', function () {
        test('returns current year as 4-digit integer', function () {
            $generator = new StudentCodeGenerator();
            $year = $generator->getCurrentAcademicYear();
            
            // Verify it's an integer
            expect($year)->toBeInt();
            
            // Verify it's 4 digits (between 1000 and 9999)
            expect($year)->toBeGreaterThanOrEqual(1000);
            expect($year)->toBeLessThanOrEqual(9999);
            
            // Verify it matches the current year
            expect($year)->toBe((int) date('Y'));
        });
        
        test('returns year within valid range', function () {
            $generator = new StudentCodeGenerator();
            $year = $generator->getCurrentAcademicYear();
            
            // Verify year is between 2024 and 2100 (as per design spec)
            expect($year)->toBeGreaterThanOrEqual(2024);
            expect($year)->toBeLessThanOrEqual(2100);
        });
        
        test('has no side effects', function () {
            $generator = new StudentCodeGenerator();
            
            // Call the method multiple times
            $year1 = $generator->getCurrentAcademicYear();
            $year2 = $generator->getCurrentAcademicYear();
            
            // Should return the same value (no side effects)
            expect($year1)->toBe($year2);
        });
    });

    describe('getNextSequenceNumber', function () {
        test('returns 1 when no accepted students exist for the year', function () {
            $generator = new StudentCodeGenerator();
            $year = 2025;
            
            $sequence = $generator->getNextSequenceNumber($year);
            
            expect($sequence)->toBe(1);
        });
        
        test('returns count + 1 when accepted students exist for the year', function () {
            $generator = new StudentCodeGenerator();
            $year = 2025;
            
            // Create 5 accepted admissions for 2025
            for ($i = 1; $i <= 5; $i++) {
                Admission::create([
                    'first_name' => 'Test',
                    'second_name' => 'Student',
                    'third_name' => 'Middle',
                    'fourth_name' => 'Last',
                    'national_id' => '12345678901' . $i,
                    'email' => "test{$i}@example.com",
                    'phone' => '01234567890',
                    'status' => 'accepted',
                    'student_code' => $year . str_pad($i, 4, '0', STR_PAD_LEFT),
                ]);
            }
            
            $sequence = $generator->getNextSequenceNumber($year);
            
            expect($sequence)->toBe(6);
        });
        
        test('only counts accepted admissions for the specified year', function () {
            $generator = new StudentCodeGenerator();
            $year = 2025;
            
            // Create 3 accepted admissions for 2025
            for ($i = 1; $i <= 3; $i++) {
                Admission::create([
                    'first_name' => 'Test',
                    'second_name' => 'Student',
                    'third_name' => 'Middle',
                    'fourth_name' => 'Last',
                    'national_id' => '12345678901' . $i,
                    'email' => "test{$i}@example.com",
                    'phone' => '01234567890',
                    'status' => 'accepted',
                    'student_code' => $year . str_pad($i, 4, '0', STR_PAD_LEFT),
                ]);
            }
            
            // Create 2 accepted admissions for 2024 (different year)
            for ($i = 1; $i <= 2; $i++) {
                Admission::create([
                    'first_name' => 'Test',
                    'second_name' => 'Student',
                    'third_name' => 'Middle',
                    'fourth_name' => 'Last',
                    'national_id' => '22345678901' . $i,
                    'email' => "test2024{$i}@example.com",
                    'phone' => '01234567890',
                    'status' => 'accepted',
                    'student_code' => '2024' . str_pad($i, 4, '0', STR_PAD_LEFT),
                ]);
            }
            
            // Create 2 pending admissions for 2025 (not accepted)
            for ($i = 1; $i <= 2; $i++) {
                Admission::create([
                    'first_name' => 'Test',
                    'second_name' => 'Student',
                    'third_name' => 'Middle',
                    'fourth_name' => 'Last',
                    'national_id' => '32345678901' . $i,
                    'email' => "pending{$i}@example.com",
                    'phone' => '01234567890',
                    'status' => 'pending',
                ]);
            }
            
            $sequence = $generator->getNextSequenceNumber($year);
            
            // Should only count the 3 accepted admissions for 2025
            expect($sequence)->toBe(4);
        });
        
        test('throws exception for year below valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->getNextSequenceNumber(2023))
                ->toThrow(\InvalidArgumentException::class, 'Year must be between 2024 and 2100');
        });
        
        test('throws exception for year above valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->getNextSequenceNumber(2101))
                ->toThrow(\InvalidArgumentException::class, 'Year must be between 2024 and 2100');
        });
        
        test('returns positive integer within valid range', function () {
            $generator = new StudentCodeGenerator();
            $year = 2025;
            
            $sequence = $generator->getNextSequenceNumber($year);
            
            expect($sequence)->toBeInt();
            expect($sequence)->toBeGreaterThanOrEqual(1);
            expect($sequence)->toBeLessThanOrEqual(9999);
        });
        
        test('has no side effects on database', function () {
            $generator = new StudentCodeGenerator();
            $year = 2025;
            
            // Create 2 accepted admissions
            for ($i = 1; $i <= 2; $i++) {
                Admission::create([
                    'first_name' => 'Test',
                    'second_name' => 'Student',
                    'third_name' => 'Middle',
                    'fourth_name' => 'Last',
                    'national_id' => '12345678901' . $i,
                    'email' => "test{$i}@example.com",
                    'phone' => '01234567890',
                    'status' => 'accepted',
                    'student_code' => $year . str_pad($i, 4, '0', STR_PAD_LEFT),
                ]);
            }
            
            $countBefore = Admission::where('status', 'accepted')->count();
            
            $generator->getNextSequenceNumber($year);
            
            $countAfter = Admission::where('status', 'accepted')->count();
            
            // Count should remain the same (no modifications)
            expect($countAfter)->toBe($countBefore);
        });
    });

    describe('formatCode', function () {
        test('formats sequence 1 as "0001"', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 1);
            
            expect($code)->toBe('20260001');
            expect($code)->toHaveLength(8);
        });
        
        test('formats sequence 42 as "0042"', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 42);
            
            expect($code)->toBe('20260042');
            expect($code)->toHaveLength(8);
        });
        
        test('formats sequence 9999 as "9999"', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 9999);
            
            expect($code)->toBe('20269999');
            expect($code)->toHaveLength(8);
        });
        
        test('includes year as first 4 characters', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 123);
            
            expect(substr($code, 0, 4))->toBe('2026');
        });
        
        test('includes zero-padded sequence as last 4 characters', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 5);
            
            expect(substr($code, 4, 4))->toBe('0005');
        });
        
        test('returns exactly 8-character string', function () {
            $generator = new StudentCodeGenerator();
            
            // Test with various sequence numbers
            $sequences = [1, 10, 100, 1000, 9999];
            
            foreach ($sequences as $seq) {
                $code = $generator->formatCode(2026, $seq);
                expect($code)->toHaveLength(8);
            }
        });
        
        test('returns all numeric characters', function () {
            $generator = new StudentCodeGenerator();
            $code = $generator->formatCode(2026, 123);
            
            expect($code)->toMatch('/^\d{8}$/');
            expect(ctype_digit($code))->toBeTrue();
        });
        
        test('throws exception for year below valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->formatCode(2023, 1))
                ->toThrow(\InvalidArgumentException::class, 'Year must be between 2024 and 2100');
        });
        
        test('throws exception for year above valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->formatCode(2101, 1))
                ->toThrow(\InvalidArgumentException::class, 'Year must be between 2024 and 2100');
        });
        
        test('throws exception for sequence below valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->formatCode(2026, 0))
                ->toThrow(\InvalidArgumentException::class, 'Sequence must be between 1 and 9999');
        });
        
        test('throws exception for sequence above valid range', function () {
            $generator = new StudentCodeGenerator();
            
            expect(fn() => $generator->formatCode(2026, 10000))
                ->toThrow(\InvalidArgumentException::class, 'Sequence must be between 1 and 9999');
        });
        
        test('has no side effects', function () {
            $generator = new StudentCodeGenerator();
            
            // Call the method multiple times with same inputs
            $code1 = $generator->formatCode(2026, 42);
            $code2 = $generator->formatCode(2026, 42);
            
            // Should return the same value (no side effects)
            expect($code1)->toBe($code2);
        });
        
        test('formats different years correctly', function () {
            $generator = new StudentCodeGenerator();
            
            $code2024 = $generator->formatCode(2024, 1);
            $code2025 = $generator->formatCode(2025, 1);
            $code2026 = $generator->formatCode(2026, 1);
            
            expect($code2024)->toBe('20240001');
            expect($code2025)->toBe('20250001');
            expect($code2026)->toBe('20260001');
        });
        
        test('zero-pads sequences correctly for all lengths', function () {
            $generator = new StudentCodeGenerator();
            
            // 1 digit sequence
            expect($generator->formatCode(2026, 1))->toBe('20260001');
            
            // 2 digit sequence
            expect($generator->formatCode(2026, 99))->toBe('20260099');
            
            // 3 digit sequence
            expect($generator->formatCode(2026, 999))->toBe('20260999');
            
            // 4 digit sequence
            expect($generator->formatCode(2026, 9999))->toBe('20269999');
        });
    });
});
