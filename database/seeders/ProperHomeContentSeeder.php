<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProperHomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        // Find or create index/home page
        $home = Page::where('slug', 'index')->first() 
            ?? Page::where('slug', 'home')->first();
        
        if (!$home || !$admin) {
            $this->command->warn('Home page or admin not found.');
            return;
        }

        // Delete existing content blocks
        ContentBlock::where('page_id', $home->id)->delete();

        // Hero Section
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'hero',
            'content' => [
                'title' => 'New Cairo University of Technology',
                'description' => 'The university has established the basic infrastructure of human resources necessary for the technical plans for social development in particular.',
                'image' => '/img/unvircity1.jpg',
                'ctaText' => 'Read More',
                'ctaLink' => '/about',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        // About Section with Video
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="text-center mb-5">
                    <h6 class="section-title bg-white text-center text-orange px-3">About</h6>
                    <h1>Welcome to New Cairo University of Technology</h1>
                </div>
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6">
                        <div style="background-color: #F4F9FF; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                            <video controls style="width:100%; height:auto;">
                                <source src="/img/about1.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div style="background-color: #F4F9FF; padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                            <p class="mb-4">We bring you the latest updates regarding your future and the opportunities provided by the New Technological University. Mahmoud El-Sheikh, the university president, announced that 80% of its seats are allocated to technical diploma holders, while only 20% are reserved for general secondary certificate holders.</p>
                            <p class="mb-4">The study period is four years (2+2), allowing students to obtain a higher-intermediate professional diploma after the first two years and enter the job market or continue for another two years to earn a professional bachelor\'s degree in technology.</p>
                            <p class="mb-4"><strong>Academic Degrees Awarded by the University:</strong></p>
                            <ul class="list-unstyled mb-4">
                                <li><i class="fa fa-arrow-right text-primary me-2"></i>Higher Professional Diploma in Technology</li>
                                <li><i class="fa fa-arrow-right text-primary me-2"></i>Professional Bachelor\'s Degree in Technology</li>
                                <li><i class="fa fa-arrow-right text-primary me-2"></i>Professional Master\'s Degree in Technology</li>
                                <li><i class="fa fa-arrow-right text-primary me-2"></i>Professional Doctorate in Technology</li>
                            </ul>
                            <a href="/about" class="btn btn-primary py-3 px-5" style="background: #D08301;">Read More</a>
                        </div>
                    </div>
                </div>',
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);

        // Admission Guide Cards
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'card_grid',
            'content' => [
                'cards' => [
                    [
                        'title' => 'Faculties Requirement',
                        'description' => 'Essential certificates and subjects for each Faculty.',
                        'image' => '',
                        'link' => '/faculties-requirements',
                        'icon' => 'fa fa-file-alt fa-3x text-primary',
                    ],
                    [
                        'title' => 'Tuition Fees & Scholarships',
                        'description' => 'New applicant fees and scholarships for all diplomas.',
                        'image' => '',
                        'link' => '/fees',
                        'icon' => 'fa fa-money-bill fa-3x text-success',
                    ],
                    [
                        'title' => 'How to Apply',
                        'description' => 'Step-by-step application process and requirements.',
                        'image' => '',
                        'link' => '/howapply',
                        'icon' => 'fa fa-clipboard-list fa-3x text-info',
                    ],
                ],
                'columns' => 3,
            ],
            'display_order' => 3,
            'created_by' => $admin->id,
        ]);

        $this->command->info('Home page content created successfully with proper structure from index.html');
    }
}
