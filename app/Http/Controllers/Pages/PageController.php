<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Competition;
use App\Models\Dean;
use App\Models\Department;
use App\Models\Event;
use App\Models\ExternalProtocol;
use App\Models\Gallery as GalleryModel;
use App\Models\Graduate;
use App\Models\InternalProtocol;
use App\Models\News;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PresidentContent;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Training;
use App\Models\TuitionFee;

class PageController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        // Get first 6 active departments
        $departments = Department::where('is_active', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        // Get latest 3 news
        $latestNews = News::where('is_active', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get latest 3 events
        $latestEvents = Event::latest()
            ->limit(3)
            ->get();

        // Get active testimonials ordered by display order
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Site settings
        $siteSettings = [
            'tagline' => 'Excellence in Technological Education',
        ];

        return view('pages.home', compact('departments', 'latestNews', 'latestEvents', 'testimonials', 'siteSettings'));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $page = Page::where('slug', 'about')->first();

        // Fetch FAQ sections
        $faqSections = [];
        if ($page) {
            $faqSections = PageSection::where('page_id', $page->id)
                ->where('section_key', 'faq')
                ->where('is_active', true)
                ->orderBy('section_order')
                ->get();
        }

        return view('pages.about', compact('page', 'faqSections'));
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();

        return view('pages.contact', compact('page'));
    }

    /**
     * Display the events page.
     */
    public function events()
    {
        $events = Event::latest()->get();

        return view('pages.events', compact('events'));
    }

    /**
     * Display the gallery page.
     */
    public function gallery()
    {
        $images = GalleryModel::where('is_active', true)->orderBy('order')->get();

        return view('pages.gallery', compact('images'));
    }

    /**
     * Display the departments page.
     */
    public function departments()
    {
        $departments = Department::where('is_active', true)->orderBy('order')->get();

        return view('pages.departments', compact('departments'));
    }

    /**
     * Display the news page.
     */
    public function news()
    {
        $news = News::where('is_active', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->get();

        return view('pages.news', compact('news'));
    }

    // About dropdown pages
    public function president()
    {
        $president = PresidentContent::first();

        return view('pages.president', compact('president'));
    }

    public function dean($id)
    {
        $dean = Dean::where('order', $id)->firstOrFail();

        return view('pages.dean', compact('dean'));
    }

    public function dean1()
    {
        return $this->dean(1);
    }

    public function dean2()
    {
        return $this->dean(2);
    }

    public function dean3()
    {
        return $this->dean(3);
    }

    public function campus()
    {
        return view('pages.campus');
    }

    public function internalProtocols()
    {
        $protocols = InternalProtocol::where('is_active', true)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('year');

        return view('pages.internal-protocols', compact('protocols'));
    }

    public function externalProtocols()
    {
        $protocols = ExternalProtocol::where('is_active', true)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('year');

        return view('pages.external-protocols', compact('protocols'));
    }

    public function reasons()
    {
        return view('pages.reasons');
    }

    public function graduates()
    {
        $graduates = Graduate::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $heroImage = SiteSetting::get('graduates_hero_image', asset('img/kk.png'));
        $heroTitle = SiteSetting::get('graduates_hero_title', 'Outstanding Students at New Cairo Technological University');

        return view('pages.graduates', compact('graduates', 'heroImage', 'heroTitle'));
    }

    public function competitions()
    {
        $competitions = Competition::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $videoUrl = SiteSetting::get('competitions_video_url', asset('img/videos/comptions.mp4'));

        return view('pages.competitions', compact('competitions', 'videoUrl'));
    }

    // Units dropdown pages
    public function digitalTrans()
    {
        return view('pages.digital-trans');
    }

    public function internationalCoop()
    {
        return view('pages.international-coop');
    }

    public function quality()
    {
        $qualityPages = Page::where('slug', 'like', 'quality-%')
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('pages.quality', compact('qualityPages'));
    }

    /**
     * Display a specific Quality sub-page by slug.
     */
    public function showQualityPage(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.quality-detail', compact('page'));
    }

    public function evaluation()
    {
        return view('pages.evaluation');
    }

    public function women()
    {
        return view('pages.women');
    }

    // Faculties dropdown pages
    public function facultyIt()
    {
        $dean = Dean::where('order', 1)->firstOrFail();

        return view('pages.faculty-it', compact('dean'));
    }

    public function facultyHealth()
    {
        $dean = Dean::where('order', 2)->firstOrFail();

        return view('pages.faculty-health', compact('dean'));
    }

    // Admissions dropdown pages
    public function admissions()
    {
        // Redirect to the actual admission application form
        return redirect()->route('admission.create');
    }

    public function howApply()
    {
        return view('pages.how-apply');
    }

    public function facultiesRequirements()
    {
        return view('pages.faculties-requirements');
    }

    public function postgraduateStudies()
    {
        return view('pages.postgraduate-studies');
    }

    public function fees()
    {
        $fees = TuitionFee::where('is_active', true)
            ->orderBy('order')
            ->get();

        $academicYear = SiteSetting::get('academic_year', '2025–2026');
        $announcement = SiteSetting::get('fees_announcement', '');

        return view('pages.fees', compact('fees', 'academicYear', 'announcement'));
    }

    // Campus dropdown pages
    public function entrepreneur()
    {
        return view('pages.entrepreneur');
    }

    public function activities()
    {
        $activities = Activity::where('is_active', true)
            ->latest()
            ->get();

        return view('pages.activities', compact('activities'));
    }

    // Staff dropdown pages
    public function staffLms()
    {
        return view('pages.staff-lms');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function members()
    {
        return view('pages.members');
    }

    // Student Services dropdown pages
    public function studentService()
    {
        return view('pages.student-service');
    }

    public function studentBooking()
    {
        return view('pages.student-booking');
    }

    public function library()
    {
        return view('pages.library');
    }

    public function trainings()
    {
        $trainings = Training::where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('pages.trainings', compact('trainings'));
    }

    public function itPostgraduate()
    {
        return view('pages.itPostgraduate');
    }

    public function mechatronicsPostgraduate()
    {
        return view('pages.mechatronicsPostgraduate');
    }

    public function energyPostgraduate()
    {
        return view('pages.energyPostgraduate');
    }

    public function petroleumPostgraduate()
    {
        return view('pages.petroleumPostgraduate');
    }

    public function prostheticsPostgraduate()
    {
        return view('pages.prostheticsPostgraduate');
    }

    public function autotronicsPostgraduate()
    {
        return view('pages.autotronicsPostgraduate');
    }

    public function postgraduateApply()
    {
        return view('pages.postgraduate-apply');
    }

    /**
     * Display a dynamic page by slug.
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.dynamic-page', compact('page'));
    }
}
