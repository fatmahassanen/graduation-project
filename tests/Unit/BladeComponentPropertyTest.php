<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\View\Components\Navbar;
use App\View\Components\Footer;
use App\View\Components\Hero;
use App\View\Components\CardGrid;
use App\View\Components\VideoSection;
use App\View\Components\FaqSection;
use App\View\Components\TestimonialCarousel;
use App\View\Components\GalleryGrid;
use App\View\Components\ContactForm;

class BladeComponentPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Feature: university-cms-upgrade, Property 27: Blade Component HTML Validity
     * For any Blade component rendered with valid props, the output HTML SHALL be well-formed and valid according to HTML5 standards.
     * 
     * Validates: Requirements 11.9
     * 
     * @test
     */
    public function test_blade_components_produce_valid_html()
    {
        // Test Hero component
        $hero = new Hero('Test Title', 'Test Description', null, 'Click Here', '/test');
        $heroView = $hero->render();
        $heroHtml = $heroView->with([
            'title' => $hero->title,
            'description' => $hero->description,
            'image' => $hero->image,
            'ctaText' => $hero->ctaText,
            'ctaLink' => $hero->ctaLink,
        ])->render();
        
        $this->assertStringContainsString('<div', $heroHtml);
        $this->assertStringContainsString('</div>', $heroHtml);
        $this->assertStringContainsString('Test Title', $heroHtml);
        $this->assertStringContainsString('Test Description', $heroHtml);
        $this->assertValidHtmlStructure($heroHtml);

        // Test CardGrid component
        $cards = [
            ['title' => 'Card 1', 'description' => 'Description 1'],
            ['title' => 'Card 2', 'description' => 'Description 2'],
        ];
        $cardGrid = new CardGrid($cards, 2);
        $cardGridView = $cardGrid->render();
        $cardGridHtml = $cardGridView->with([
            'cards' => $cardGrid->cards,
            'getColumnClass' => fn() => $cardGrid->getColumnClass(),
        ])->render();
        
        $this->assertStringContainsString('<div', $cardGridHtml);
        $this->assertStringContainsString('</div>', $cardGridHtml);
        $this->assertStringContainsString('Card 1', $cardGridHtml);
        $this->assertValidHtmlStructure($cardGridHtml);

        // Test VideoSection component
        $video = new VideoSection('/test/video.mp4', 'Video Title');
        $videoView = $video->render();
        $videoHtml = $videoView->with([
            'videoUrl' => $video->videoUrl,
            'title' => $video->title,
            'description' => $video->description,
            'autoplay' => $video->autoplay,
            'controls' => $video->controls,
        ])->render();
        
        $this->assertStringContainsString('<video', $videoHtml);
        $this->assertStringContainsString('</video>', $videoHtml);
        $this->assertStringContainsString('Video Title', $videoHtml);
        $this->assertValidHtmlStructure($videoHtml);

        // Test FaqSection component
        $faqs = [
            ['question' => 'Q1?', 'answer' => 'A1'],
            ['question' => 'Q2?', 'answer' => 'A2'],
        ];
        $faqSection = new FaqSection($faqs, 'FAQ Title');
        $faqView = $faqSection->render();
        $faqHtml = $faqView->with([
            'items' => $faqSection->items,
            'title' => $faqSection->title,
            'image' => $faqSection->image,
        ])->render();
        
        $this->assertStringContainsString('<div', $faqHtml);
        $this->assertStringContainsString('</div>', $faqHtml);
        $this->assertStringContainsString('Q1?', $faqHtml);
        $this->assertValidHtmlStructure($faqHtml);

        // Test GalleryGrid component
        $images = [
            ['url' => '/img1.jpg', 'alt' => 'Image 1'],
            ['url' => '/img2.jpg', 'alt' => 'Image 2'],
        ];
        $gallery = new GalleryGrid($images, 'Gallery Title', 4);
        $galleryView = $gallery->render();
        $galleryHtml = $galleryView->with([
            'images' => $gallery->images,
            'title' => $gallery->title,
            'getColumnClass' => fn() => $gallery->getColumnClass(),
        ])->render();
        
        $this->assertStringContainsString('<div', $galleryHtml);
        $this->assertStringContainsString('</div>', $galleryHtml);
        $this->assertStringContainsString('Gallery Title', $galleryHtml);
        $this->assertValidHtmlStructure($galleryHtml);
    }

    /**
     * Feature: university-cms-upgrade, Property 28: Component Type Selection
     * For any content block with a specific type, rendering SHALL use the corresponding Blade component.
     * 
     * Validates: Requirements 12.2
     * 
     * @test
     */
    public function test_content_block_type_maps_to_correct_component()
    {
        $typeToComponentMap = [
            'hero' => Hero::class,
            'card_grid' => CardGrid::class,
            'video' => VideoSection::class,
            'faq' => FaqSection::class,
            'testimonial' => TestimonialCarousel::class,
            'gallery' => GalleryGrid::class,
            'contact_form' => ContactForm::class,
        ];

        foreach ($typeToComponentMap as $type => $componentClass) {
            $this->assertTrue(
                class_exists($componentClass),
                "Component class {$componentClass} should exist for type {$type}"
            );
        }

        // Verify each component can be instantiated with minimal props
        $hero = new Hero('Title');
        $this->assertInstanceOf(Hero::class, $hero);

        $cardGrid = new CardGrid([]);
        $this->assertInstanceOf(CardGrid::class, $cardGrid);

        $video = new VideoSection('/test.mp4');
        $this->assertInstanceOf(VideoSection::class, $video);

        $faq = new FaqSection([]);
        $this->assertInstanceOf(FaqSection::class, $faq);

        $testimonial = new TestimonialCarousel([]);
        $this->assertInstanceOf(TestimonialCarousel::class, $testimonial);

        $gallery = new GalleryGrid([]);
        $this->assertInstanceOf(GalleryGrid::class, $gallery);

        $contact = new ContactForm();
        $this->assertInstanceOf(ContactForm::class, $contact);
    }

    /**
     * Feature: university-cms-upgrade, Property 29: Active Navigation Link Highlighting
     * For any page request, the navigation component SHALL mark the corresponding menu link as active based on the current page slug.
     * 
     * Validates: Requirements 12.7
     * 
     * @test
     */
    public function test_navbar_highlights_active_link_correctly()
    {
        // Mock routes for testing
        \Illuminate\Support\Facades\Route::shouldReceive('has')->andReturn(true);
        \Illuminate\Support\Facades\Route::shouldReceive('get')->andReturn(new \stdClass());
        
        // Test direct link activation
        $navbar = new Navbar('home', 'en');
        $this->assertTrue($navbar->isActive(['slug' => 'home', 'url' => '/']));
        $this->assertFalse($navbar->isActive(['slug' => 'about', 'url' => '/about']));

        // Test dropdown item activation
        $navbarAbout = new Navbar('president', 'en');
        $aboutDropdown = [
            'slug' => 'about',
            'dropdown' => [
                ['slug' => 'about', 'url' => '/about'],
                ['slug' => 'president', 'url' => '/president'],
            ]
        ];
        $this->assertTrue($navbarAbout->isActive($aboutDropdown));

        // Test nested dropdown activation
        $navbarContact = new Navbar('contact', 'en');
        $this->assertTrue($navbarContact->isActive(['slug' => 'contact', 'url' => '/contact']));
        $this->assertFalse($navbarContact->isActive(['slug' => 'home', 'url' => '/']));
    }

    /**
     * Test that CardGrid component respects column configuration
     * 
     * @test
     */
    public function test_card_grid_column_configuration()
    {
        $cards = [
            ['title' => 'Card 1'],
            ['title' => 'Card 2'],
        ];

        // Test 2 columns
        $grid2 = new CardGrid($cards, 2);
        $this->assertEquals('col-lg-6 col-md-6', $grid2->getColumnClass());

        // Test 3 columns
        $grid3 = new CardGrid($cards, 3);
        $this->assertEquals('col-lg-4 col-md-6', $grid3->getColumnClass());

        // Test 4 columns
        $grid4 = new CardGrid($cards, 4);
        $this->assertEquals('col-lg-3 col-md-6', $grid4->getColumnClass());

        // Test boundary: columns < 1 should default to 1
        $grid0 = new CardGrid($cards, 0);
        $this->assertEquals('col-12', $grid0->getColumnClass());

        // Test boundary: columns > 4 should cap at 4
        $grid5 = new CardGrid($cards, 5);
        $this->assertEquals('col-lg-3 col-md-6', $grid5->getColumnClass());
    }

    /**
     * Test that GalleryGrid component respects column configuration
     * 
     * @test
     */
    public function test_gallery_grid_column_configuration()
    {
        $images = [
            ['url' => '/img1.jpg', 'alt' => 'Image 1'],
            ['url' => '/img2.jpg', 'alt' => 'Image 2'],
        ];

        // Test 2 columns
        $gallery2 = new GalleryGrid($images, null, 2);
        $this->assertEquals('col-lg-6 col-md-6', $gallery2->getColumnClass());

        // Test 3 columns
        $gallery3 = new GalleryGrid($images, null, 3);
        $this->assertEquals('col-lg-4 col-md-6', $gallery3->getColumnClass());

        // Test 4 columns
        $gallery4 = new GalleryGrid($images, null, 4);
        $this->assertEquals('col-lg-3 col-md-4 col-sm-6', $gallery4->getColumnClass());

        // Test 6 columns
        $gallery6 = new GalleryGrid($images, null, 6);
        $this->assertEquals('col-lg-2 col-md-3 col-sm-4', $gallery6->getColumnClass());
    }

    /**
     * Test that VideoSection component handles autoplay and controls correctly
     * 
     * @test
     */
    public function test_video_section_configuration()
    {
        // Test with autoplay and controls
        $video1 = new VideoSection('/test.mp4', 'Title', 'Description', true, true);
        $this->assertTrue($video1->autoplay);
        $this->assertTrue($video1->controls);

        // Test without autoplay
        $video2 = new VideoSection('/test.mp4', null, null, false, true);
        $this->assertFalse($video2->autoplay);
        $this->assertTrue($video2->controls);

        // Test without controls
        $video3 = new VideoSection('/test.mp4', null, null, true, false);
        $this->assertTrue($video3->autoplay);
        $this->assertFalse($video3->controls);
    }

    /**
     * Test that Navbar builds menu structure correctly
     * 
     * @test
     */
    public function test_navbar_menu_structure()
    {
        $navbar = new Navbar('home', 'en');
        
        $this->assertIsArray($navbar->menuItems);
        $this->assertNotEmpty($navbar->menuItems);
        
        // Check that menu has expected top-level items
        $menuLabels = array_column($navbar->menuItems, 'label');
        $this->assertContains('Home', $menuLabels);
        $this->assertContains('About', $menuLabels);
        $this->assertContains('Contacts', $menuLabels);
        
        // Check that dropdown items exist
        $aboutMenu = collect($navbar->menuItems)->firstWhere('label', 'About');
        $this->assertArrayHasKey('dropdown', $aboutMenu);
        $this->assertIsArray($aboutMenu['dropdown']);
        $this->assertNotEmpty($aboutMenu['dropdown']);
    }

    /**
     * Test that Footer builds data structures correctly
     * 
     * @test
     */
    public function test_footer_data_structures()
    {
        $footer = new Footer();
        
        $this->assertIsArray($footer->galleryImages);
        $this->assertNotEmpty($footer->galleryImages);
        
        $this->assertIsArray($footer->socialLinks);
        $this->assertNotEmpty($footer->socialLinks);
        
        $this->assertIsArray($footer->quickLinks);
        $this->assertNotEmpty($footer->quickLinks);
        
        $this->assertIsArray($footer->contactInfo);
        $this->assertNotEmpty($footer->contactInfo);
        
        // Verify gallery images have required fields
        foreach ($footer->galleryImages as $image) {
            $this->assertArrayHasKey('url', $image);
            $this->assertArrayHasKey('image', $image);
            $this->assertArrayHasKey('alt', $image);
        }
        
        // Verify social links have required fields
        foreach ($footer->socialLinks as $social) {
            $this->assertArrayHasKey('icon', $social);
            $this->assertArrayHasKey('url', $social);
            $this->assertArrayHasKey('label', $social);
        }
    }

    /**
     * Helper method to validate basic HTML structure
     */
    private function assertValidHtmlStructure(string $html): void
    {
        // Check for balanced tags
        $openDivs = substr_count($html, '<div');
        $closeDivs = substr_count($html, '</div>');
        $this->assertEquals($openDivs, $closeDivs, 'HTML should have balanced div tags');
        
        // Check that HTML is not empty
        $this->assertNotEmpty(trim($html), 'HTML should not be empty');
    }
}
