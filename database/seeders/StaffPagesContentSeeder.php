<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffPagesContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        // Update Profile page
        $profilePage = Page::where('slug', 'profile')->where('language', 'en')->first();
        if ($profilePage) {
            ContentBlock::where('page_id', $profilePage->id)->delete();
            
            ContentBlock::create([
                'page_id' => $profilePage->id,
                'type' => 'hero',
                'content' => [
                    'title' => 'Staff Profile & Resources',
                    'description' => 'Access your profile, manage information, and utilize university resources.',
                    'image' => '/img/univercty2.jpg',
                ],
                'display_order' => 1,
                'created_by' => $admin->id,
            ]);

            ContentBlock::create([
                'page_id' => $profilePage->id,
                'type' => 'card_grid',
                'content' => [
                    'cards' => [
                        [
                            'title' => 'Staff Portal Login',
                            'description' => 'Access the staff portal to manage your profile and view resources',
                            'icon' => 'fa fa-user-circle fa-3x text-primary',
                            'link' => '/staff-lms',
                        ],
                        [
                            'title' => 'Update Profile',
                            'description' => 'Update your personal information, contact details, and preferences',
                            'icon' => 'fa fa-edit fa-3x text-success',
                            'link' => '#',
                        ],
                        [
                            'title' => 'Academic Resources',
                            'description' => 'Access teaching materials, course management tools, and academic resources',
                            'icon' => 'fa fa-book fa-3x text-info',
                            'link' => '/staff-lms',
                        ],
                        [
                            'title' => 'Research Portal',
                            'description' => 'Submit research proposals, track projects, and access research funding',
                            'icon' => 'fa fa-flask fa-3x text-warning',
                            'link' => '#',
                        ],
                        [
                            'title' => 'HR Services',
                            'description' => 'Access payroll, benefits, leave requests, and HR documentation',
                            'icon' => 'fa fa-briefcase fa-3x text-danger',
                            'link' => '#',
                        ],
                        [
                            'title' => 'Support & Help',
                            'description' => 'Get technical support and access help documentation',
                            'icon' => 'fa fa-question-circle fa-3x text-secondary',
                            'link' => '/contact',
                        ],
                    ],
                    'columns' => 3,
                ],
                'display_order' => 2,
                'created_by' => $admin->id,
            ]);

            ContentBlock::create([
                'page_id' => $profilePage->id,
                'type' => 'text',
                'content' => [
                    'body' => '<div class="row">
                        <div class="col-md-6">
                            <h3>Quick Links</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fa fa-chevron-right text-primary me-2"></i><a href="/staff-lms">Staff LMS</a></li>
                                <li class="mb-2"><i class="fa fa-chevron-right text-primary me-2"></i><a href="/library">Library Resources</a></li>
                                <li class="mb-2"><i class="fa fa-chevron-right text-primary me-2"></i><a href="https://www.ekb.eg/" target="_blank">Egyptian Knowledge Bank</a></li>
                                <li class="mb-2"><i class="fa fa-chevron-right text-primary me-2"></i><a href="/events">University Events</a></li>
                                <li class="mb-2"><i class="fa fa-chevron-right text-primary me-2"></i><a href="/news">News & Announcements</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h3>Important Information</h3>
                            <div class="alert alert-info">
                                <h5><i class="fa fa-info-circle me-2"></i>Staff Portal Access</h5>
                                <p>To access the full staff portal and manage your profile, please use your university credentials to log in through the Staff LMS.</p>
                                <a href="/staff-lms" class="btn btn-primary btn-sm">Go to Staff LMS</a>
                            </div>
                            <div class="alert alert-warning">
                                <h5><i class="fa fa-exclamation-triangle me-2"></i>Need Help?</h5>
                                <p>If you have trouble accessing your profile or need technical support, please contact the IT helpdesk.</p>
                                <a href="/contact" class="btn btn-warning btn-sm">Contact Support</a>
                            </div>
                        </div>
                    </div>',
                ],
                'display_order' => 3,
                'created_by' => $admin->id,
            ]);

            $this->command->info('Profile page updated successfully!');
        }

        // Update Staff LMS page
        $staffLmsPage = Page::where('slug', 'staff-lms')->where('language', 'en')->first();
        if ($staffLmsPage) {
            ContentBlock::where('page_id', $staffLmsPage->id)->delete();
            
            ContentBlock::create([
                'page_id' => $staffLmsPage->id,
                'type' => 'hero',
                'content' => [
                    'title' => 'Staff Learning Management System',
                    'description' => 'Access course management, grading, and communication tools.',
                    'image' => '/img/univercty2.jpg',
                ],
                'display_order' => 1,
                'created_by' => $admin->id,
            ]);

            ContentBlock::create([
                'page_id' => $staffLmsPage->id,
                'type' => 'text',
                'content' => [
                    'body' => '<div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="card shadow-lg">
                                <div class="card-body p-5">
                                    <h3 class="text-center mb-4">Staff Portal Login</h3>
                                    <p class="text-center text-muted mb-4">Please enter your university credentials to access the staff portal</p>
                                    
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle me-2"></i>
                                        <strong>Note:</strong> This is a placeholder login page. In production, this would connect to your university\'s authentication system (LDAP, SSO, etc.)
                                    </div>

                                    <form action="#" method="POST" class="mt-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="your.email@nctu.edu.eg" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mb-3">Login to Staff Portal</button>
                                        <div class="text-center">
                                            <a href="#" class="text-muted">Forgot Password?</a>
                                        </div>
                                    </form>

                                    <hr class="my-4">

                                    <h5 class="mb-3">LMS Features</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Course content management</li>
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Assignment and grading tools</li>
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Student communication</li>
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Attendance tracking</li>
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Performance analytics</li>
                                        <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Resource library</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>',
                ],
                'display_order' => 2,
                'created_by' => $admin->id,
            ]);

            $this->command->info('Staff LMS page updated successfully!');
        }
    }
}
