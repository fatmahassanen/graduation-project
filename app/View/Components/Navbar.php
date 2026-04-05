<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Navbar extends Component
{
    public string $currentPage;
    public string $language;
    public array $menuItems;

    /**
     * Create a new component instance.
     */
    public function __construct(string $currentPage = '', string $language = 'en')
    {
        $this->currentPage = $currentPage;
        $this->language = $language;
        $this->menuItems = $this->buildMenuStructure();
    }

    /**
     * Build the navigation menu structure
     */
    private function buildMenuStructure(): array
    {
        // Helper function to safely generate route or return fallback URL
        $safeRoute = function($routeName, $params = [], $fallback = '#') {
            try {
                return route($routeName, $params);
            } catch (\Exception $e) {
                return $fallback;
            }
        };

        return [
            [
                'label' => 'Home',
                'url' => $safeRoute('home', [], '/'),
                'slug' => 'home',
            ],
            [
                'label' => 'About',
                'slug' => 'about',
                'dropdown' => [
                    ['label' => 'About NCT', 'url' => $safeRoute('page.show', ['slug' => 'about'], '/about'), 'slug' => 'about'],
                    ['label' => 'University President', 'url' => $safeRoute('page.show', ['slug' => 'president'], '/president'), 'slug' => 'president'],
                    ['label' => 'Dean of Industrial & Energy Technology', 'url' => $safeRoute('page.show', ['slug' => 'dean1'], '/dean1'), 'slug' => 'dean1'],
                    ['label' => 'Dean of Applied Health Sciences Technology', 'url' => $safeRoute('page.show', ['slug' => 'dean2'], '/dean2'), 'slug' => 'dean2'],
                    ['label' => 'Students Affairs Vice Dean', 'url' => $safeRoute('page.show', ['slug' => 'dean3'], '/dean3'), 'slug' => 'dean3'],
                    ['label' => 'Campus Tour', 'url' => $safeRoute('page.show', ['slug' => 'campus'], '/campus'), 'slug' => 'campus'],
                    ['label' => 'Internal Protocols', 'url' => $safeRoute('page.show', ['slug' => 'internal-protocols'], '/internal-protocols'), 'slug' => 'internal-protocols'],
                    ['label' => 'External Protocols', 'url' => $safeRoute('page.show', ['slug' => 'external-protocols'], '/external-protocols'), 'slug' => 'external-protocols'],
                    ['label' => 'Top 10 Reasons', 'url' => $safeRoute('page.show', ['slug' => 'reasons'], '/reasons'), 'slug' => 'reasons'],
                    ['label' => 'Competitions', 'url' => $safeRoute('page.show', ['slug' => 'competitions'], '/competitions'), 'slug' => 'competitions'],
                    ['label' => 'Graduate Achievements', 'url' => $safeRoute('page.show', ['slug' => 'graduates'], '/graduates'), 'slug' => 'graduates'],
                ],
            ],
            [
                'label' => 'Units',
                'slug' => 'units',
                'dropdown' => [
                    ['label' => 'Digital Transformation', 'url' => $safeRoute('page.show', ['slug' => 'digital-transformation'], '/digital-transformation'), 'slug' => 'digital-transformation'],
                    ['label' => 'International Cooperation', 'url' => $safeRoute('page.show', ['slug' => 'international-cooperation'], '/international-cooperation'), 'slug' => 'international-cooperation'],
                    ['label' => 'Quality Assurance', 'url' => $safeRoute('page.show', ['slug' => 'quality'], '/quality'), 'slug' => 'quality'],
                    ['label' => 'Measurement and Evaluation', 'url' => $safeRoute('page.show', ['slug' => 'evaluation'], '/evaluation'), 'slug' => 'evaluation'],
                    ['label' => 'Combating Violence Against Women', 'url' => $safeRoute('page.show', ['slug' => 'women'], '/women'), 'slug' => 'women'],
                ],
            ],
            [
                'label' => 'Faculties',
                'slug' => 'faculties',
                'dropdown' => [
                    ['label' => 'Faculty of Industrial and Energy Technology', 'url' => $safeRoute('page.show', ['slug' => 'faculty-it'], '/faculty-it'), 'slug' => 'faculty-it'],
                    ['label' => 'Faculty of Applied Health Sciences Technology', 'url' => $safeRoute('page.show', ['slug' => 'faculty-health'], '/faculty-health'), 'slug' => 'faculty-health'],
                ],
            ],
            [
                'label' => 'Media',
                'slug' => 'media',
                'dropdown' => [
                    ['label' => 'Events', 'url' => $safeRoute('page.show', ['slug' => 'events'], '/events'), 'slug' => 'events'],
                    ['label' => 'Gallery', 'url' => $safeRoute('page.show', ['slug' => 'gallery'], '/gallery'), 'slug' => 'gallery'],
                    ['label' => 'News', 'url' => $safeRoute('page.show', ['slug' => 'news'], '/news'), 'slug' => 'news'],
                ],
            ],
            [
                'label' => 'Admissions',
                'slug' => 'admissions',
                'dropdown' => [
                    ['label' => 'Admission Requirements', 'url' => $safeRoute('page.show', ['slug' => 'admissions'], '/admissions'), 'slug' => 'admissions'],
                    ['label' => 'How to Apply Online', 'url' => $safeRoute('page.show', ['slug' => 'how-apply'], '/how-apply'), 'slug' => 'how-apply'],
                    ['label' => 'Faculties Requirements', 'url' => $safeRoute('page.show', ['slug' => 'faculties-requirements'], '/faculties-requirements'), 'slug' => 'faculties-requirements'],
                    ['label' => 'Postgraduate Programs', 'url' => $safeRoute('page.show', ['slug' => 'postgraduate-studies'], '/postgraduate-studies'), 'slug' => 'postgraduate-studies'],
                    ['label' => 'Tuition Fees & Scholarships', 'url' => $safeRoute('page.show', ['slug' => 'fees'], '/fees'), 'slug' => 'fees'],
                ],
            ],
            [
                'label' => 'Campus',
                'slug' => 'campus',
                'dropdown' => [
                    ['label' => 'Enactus', 'url' => 'https://enactus.org/', 'slug' => 'enactus', 'external' => true],
                    ['label' => 'Entrepreneur', 'url' => $safeRoute('page.show', ['slug' => 'entrepreneur'], '/entrepreneur'), 'slug' => 'entrepreneur'],
                    ['label' => 'Student Activities', 'url' => $safeRoute('page.show', ['slug' => 'activities'], '/activities'), 'slug' => 'activities'],
                ],
            ],
            [
                'label' => 'Staff',
                'slug' => 'staff',
                'dropdown' => [
                    ['label' => 'Staff LMS', 'url' => $safeRoute('page.show', ['slug' => 'staff-lms'], '/staff-lms'), 'slug' => 'staff-lms'],
                    ['label' => 'Profile', 'url' => $safeRoute('page.show', ['slug' => 'profile'], '/profile'), 'slug' => 'profile'],
                    ['label' => 'Staff Members', 'url' => $safeRoute('page.show', ['slug' => 'members'], '/members'), 'slug' => 'members'],
                    ['label' => 'Egyptian Knowledge Bank- EKB', 'url' => 'https://www.ekb.eg/', 'slug' => 'ekb', 'external' => true],
                ],
            ],
            [
                'label' => 'Student Services',
                'slug' => 'student-services',
                'dropdown' => [
                    ['label' => 'Students LMS', 'url' => $safeRoute('page.show', ['slug' => 'student-service'], '/student-service'), 'slug' => 'student-service'],
                    ['label' => 'Student Affairs', 'url' => $safeRoute('page.show', ['slug' => 'student-booking'], '/student-booking'), 'slug' => 'student-booking'],
                    ['label' => 'Library', 'url' => $safeRoute('page.show', ['slug' => 'library'], '/library'), 'slug' => 'library'],
                    ['label' => 'Training', 'url' => $safeRoute('page.show', ['slug' => 'trainings'], '/trainings'), 'slug' => 'trainings'],
                ],
            ],
            [
                'label' => 'Contacts',
                'url' => $safeRoute('page.show', ['slug' => 'contact'], '/contact'),
                'slug' => 'contact',
            ],
        ];
    }

    /**
     * Check if a menu item or its children are active
     */
    public function isActive(array $item): bool
    {
        if (isset($item['url']) && $item['slug'] === $this->currentPage) {
            return true;
        }

        if (isset($item['dropdown'])) {
            foreach ($item['dropdown'] as $child) {
                if ($child['slug'] === $this->currentPage) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.navbar');
    }
}
