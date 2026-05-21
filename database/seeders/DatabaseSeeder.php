<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================
        // CRITICAL: ALL SEEDERS REGISTERED HERE
        // ============================================
        
        // 1. FOUNDATION SEEDERS (Must run first)
        // --------------------------------------------
        $this->call([
            // Users and Authentication
            UserSeeder::class,
            
            // Site Configuration
            SiteSettingSeeder::class,
            PageSeeder::class,
            AboutPageSeeder::class,
            QualityUnitSeeder::class,
            
            // 2. INSTITUTIONAL MANAGEMENT
            // --------------------------------------------
            // President and Deans (Institutional Leadership)
            InstitutionalManagementSeeder::class,
            PresidentContentSeeder::class,  // Backup/alternative president seeder
            DeansSeeder::class,              // Backup/alternative deans seeder
            
            // 3. ACADEMIC STRUCTURE
            // --------------------------------------------
            // Departments and Programs
            DepartmentSeeder::class,
            
            // 4. ADMISSIONS & STUDENTS
            // --------------------------------------------
            // Admission Applications
            AdmissionSeeder::class,
            PreApplicationSeeder::class,
            
            // Tuition and Fees
            TuitionFeesSeeder::class,
            
            // 5. CONTENT & MEDIA
            // --------------------------------------------
            // News and Events
            NewsSeeder::class,
            EventSeeder::class,
            EventsDataSeeder::class,  // Additional events data
            
            // Student Achievements
            GraduatesSeeder::class,
            CompetitionsSeeder::class,
            
            // Activities and Training
            ActivitiesDataSeeder::class,
            TrainingsDataSeeder::class,
            
            // 6. PROTOCOLS & PARTNERSHIPS
            // --------------------------------------------
            ExternalProtocolsSeeder::class,
            
            // 7. TESTIMONIALS & FEEDBACK
            // --------------------------------------------
            TestimonialsSeeder::class,
        ]);
        
        // ============================================
        // SUMMARY OF SEEDED DATA
        // ============================================
        $this->command->info('✅ All seeders executed successfully!');
        $this->command->info('📊 Database fully populated with:');
        $this->command->info('   - Users & Authentication');
        $this->command->info('   - Site Settings & Pages');
        $this->command->info('   - Institutional Management (President & Deans)');
        $this->command->info('   - Academic Departments');
        $this->command->info('   - Admissions & Tuition Fees');
        $this->command->info('   - News, Events & Activities');
        $this->command->info('   - Graduates & Competitions');
        $this->command->info('   - Training Programs');
        $this->command->info('   - External Protocols');
        $this->command->info('   - Testimonials');
        $this->command->info('🚀 Your database is ready!');
    }
}
