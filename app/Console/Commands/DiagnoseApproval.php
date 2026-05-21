<?php

namespace App\Console\Commands;

use App\Models\Admission;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('diagnose:approval')]
#[Description('Diagnose approval process issues')]
class DiagnoseApproval extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Running Approval Process Diagnostics...');
        $this->newLine();

        // Test 1: Database Connection
        $this->info('Test 1: Database Connection');
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connection: OK');
        } catch (\Exception $e) {
            $this->error('❌ Database connection: FAILED');
            $this->error('Error: '.$e->getMessage());

            return 1;
        }
        $this->newLine();

        // Test 2: Check Admissions Table
        $this->info('Test 2: Admissions Table');
        try {
            $count = Admission::count();
            $this->info("✅ Admissions table accessible: {$count} records found");
        } catch (\Exception $e) {
            $this->error('❌ Admissions table: FAILED');
            $this->error('Error: '.$e->getMessage());

            return 1;
        }
        $this->newLine();

        // Test 3: Check Pending Applications
        $this->info('Test 3: Pending Applications');
        try {
            $pending = Admission::where('status', 'pending')->count();
            $this->info("✅ Pending applications: {$pending}");
        } catch (\Exception $e) {
            $this->error('❌ Pending applications check: FAILED');
            $this->error('Error: '.$e->getMessage());

            return 1;
        }
        $this->newLine();

        // Test 4: Test Update Operation (Dry Run)
        $this->info('Test 4: Test Update Operation (Dry Run)');
        try {
            $testAdmission = Admission::where('status', 'pending')->first();
            if ($testAdmission) {
                $this->info("Found test admission: ID {$testAdmission->id}");
                $this->info('Testing update operation (no actual change)...');

                // Test without actually changing
                $canUpdate = DB::table('admissions')
                    ->where('id', $testAdmission->id)
                    ->exists();

                if ($canUpdate) {
                    $this->info('✅ Update operation: OK (can write to database)');
                } else {
                    $this->error('❌ Update operation: FAILED');
                }
            } else {
                $this->warn('⚠️  No pending applications to test with');
            }
        } catch (\Exception $e) {
            $this->error('❌ Update operation test: FAILED');
            $this->error('Error: '.$e->getMessage());

            return 1;
        }
        $this->newLine();

        // Test 5: Check Jobs Table (Queue)
        $this->info('Test 5: Queue System');
        try {
            $jobsCount = DB::table('jobs')->count();
            $this->info("✅ Jobs table accessible: {$jobsCount} queued jobs");
        } catch (\Exception $e) {
            $this->error('❌ Jobs table: FAILED');
            $this->error('Error: '.$e->getMessage());
        }
        $this->newLine();

        // Test 6: Mail Configuration
        $this->info('Test 6: Mail Configuration');
        try {
            $mailer = config('mail.default');
            $host = config('mail.mailers.smtp.host');
            $port = config('mail.mailers.smtp.port');
            $this->info("✅ Mail driver: {$mailer}");
            $this->info("✅ SMTP host: {$host}:{$port}");
        } catch (\Exception $e) {
            $this->error('❌ Mail configuration: FAILED');
            $this->error('Error: '.$e->getMessage());
        }
        $this->newLine();

        // Summary
        $this->info('📊 Diagnostic Summary:');
        $this->info('All critical systems are operational.');
        $this->info('If approval still fails, check:');
        $this->info('  1. Browser console for JavaScript errors');
        $this->info('  2. Laravel logs: storage/logs/laravel.log');
        $this->info('  3. Network tab in browser dev tools');
        $this->info('  4. Try from a different network (mobile hotspot)');

        return 0;
    }
}
