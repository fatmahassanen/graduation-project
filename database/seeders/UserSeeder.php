<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::firstOrCreate(
            ['email' => 'admin@nctu.edu.eg'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Content Editor
        User::firstOrCreate(
            ['email' => 'editor@nctu.edu.eg'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password'),
                'role' => 'content_editor',
                'email_verified_at' => now(),
            ]
        );

        // Create Faculty Admin for IT Faculty
        User::firstOrCreate(
            ['email' => 'it-admin@nctu.edu.eg'],
            [
                'name' => 'IT Faculty Admin',
                'password' => Hash::make('password'),
                'role' => 'faculty_admin',
                'faculty_category' => 'faculties',
                'email_verified_at' => now(),
            ]
        );

        // Create Faculty Admin for Admissions
        User::firstOrCreate(
            ['email' => 'admissions@nctu.edu.eg'],
            [
                'name' => 'Admissions Admin',
                'password' => Hash::make('password'),
                'role' => 'faculty_admin',
                'faculty_category' => 'admissions',
                'email_verified_at' => now(),
            ]
        );

        // Create additional test users
        User::firstOrCreate(
            ['email' => 'quality-admin@nctu.edu.eg'],
            [
                'name' => 'Quality Assurance Admin',
                'password' => Hash::make('password'),
                'role' => 'faculty_admin',
                'faculty_category' => 'quality',
                'email_verified_at' => now(),
            ]
        );
    }
}
