<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    public array $galleryImages;
    public array $socialLinks;
    public array $quickLinks;
    public array $contactInfo;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->galleryImages = $this->buildGalleryImages();
        $this->socialLinks = $this->buildSocialLinks();
        $this->quickLinks = $this->buildQuickLinks();
        $this->contactInfo = $this->buildContactInfo();
    }

    /**
     * Build gallery images array
     */
    private function buildGalleryImages(): array
    {
        $safeRoute = function($routeName, $params = [], $fallback = '#') {
            try {
                return route($routeName, $params);
            } catch (\Exception $e) {
                return $fallback;
            }
        };

        return [
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/information technology.jpg'), 'alt' => 'Information Technology'],
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/Mechatronic.jpg'), 'alt' => 'Mechatronics'],
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/Autotronics.jpg'), 'alt' => 'Autotronics'],
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/Petroleum engineering.jpg'), 'alt' => 'Petroleum Engineering'],
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/Prosthetics.jpg'), 'alt' => 'Prosthetics'],
            ['url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments'), 'image' => asset('img/Departments/Renewable energy.jpg'), 'alt' => 'Renewable Energy'],
        ];
    }

    /**
     * Build social media links array
     */
    private function buildSocialLinks(): array
    {
        return [
            ['icon' => 'fab fa-facebook-f', 'url' => 'https://www.facebook.com/nctu.edu.eg/?locale=ar_AR', 'label' => 'Facebook'],
            ['icon' => 'fab fa-instagram', 'url' => 'https://www.instagram.com/explore/locations/113014853445529/new-cairo-technological-university/', 'label' => 'Instagram'],
            ['icon' => 'fab fa-telegram', 'url' => 'https://t.me/+hu88qUXmcXNlNmQ0', 'label' => 'Telegram'],
            ['icon' => 'fab fa-linkedin-in', 'url' => 'https://www.linkedin.com/school/nct-uni/', 'label' => 'LinkedIn'],
        ];
    }

    /**
     * Build quick links array
     */
    private function buildQuickLinks(): array
    {
        $safeRoute = function($routeName, $params = [], $fallback = '#') {
            try {
                return route($routeName, $params);
            } catch (\Exception $e) {
                return $fallback;
            }
        };

        return [
            ['label' => 'About Us', 'url' => $safeRoute('page.show', ['slug' => 'about'], '/about')],
            ['label' => 'Contact Us', 'url' => $safeRoute('page.show', ['slug' => 'contact'], '/contact')],
            ['label' => 'Courses', 'url' => $safeRoute('page.show', ['slug' => 'departments'], '/departments')],
        ];
    }

    /**
     * Build contact information array
     */
    private function buildContactInfo(): array
    {
        return [
            [
                'icon' => 'fa fa-map-marker-alt',
                'label' => 'Address',
                'value' => 'El Lotus, First New Cairo, New Cairo',
                'url' => 'https://www.google.com/maps/search/%D8%AC%D8%A7%D9%85%D8%B9%D9%87+%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D9%87+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF%D9%87+%D8%A7%D9%84%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7%E2%80%AD%E2%80%AD/@30.022714,31.5229726,17z?entry=ttu&g_ep=EgoyMDI1MDQwOS4wIKXMDSoASAFQAw%3D%3D',
            ],
            [
                'icon' => 'fa fa-phone-alt',
                'label' => 'Phone',
                'value' => '0225390250',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.footer');
    }
}
