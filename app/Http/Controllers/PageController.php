<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService
    ) {
    }

    /**
     * Display the home page.
     */
    public function showHome(Request $request): View
    {
        // Get language from request or default to current locale
        $language = $request->input('language', app()->getLocale());

        // Try to find a page with slug 'home' or 'welcome'
        $page = $this->pageService->getPublishedPageBySlug('home', $language)
            ?? $this->pageService->getPublishedPageBySlug('welcome', $language)
            ?? $this->pageService->getPublishedPageBySlug('index', $language);

        // If no home page found, return 404
        if (!$page) {
            abort(404, 'Home page not found. Please create a page with slug "home", "welcome", or "index".');
        }

        // Eager load media relationships for content blocks
        $page->load('contentBlocks');

        // Pass page data and SEO metadata to view
        return view('pages.show', [
            'page' => $page,
            'currentPage' => 'home',
            'metaTitle' => $page->meta_title ?? $page->title,
            'metaDescription' => $page->meta_description ?? '',
            'metaKeywords' => $page->meta_keywords ?? '',
            'ogImage' => $page->og_image ?? null,
            'translationUnavailable' => false,
        ]);
    }

    /**
     * Display the specified page.
     */
    public function show(Request $request, string $slug): View
    {
        // Get language from request or default to current locale
        $language = $request->input('language', app()->getLocale());

        // Get published page by slug and language with eager-loaded relationships
        $page = $this->pageService->getPublishedPageBySlug($slug, $language);

        // Check if translation is unavailable
        $translationUnavailable = session('translation_unavailable', false);

        // Return 404 if page not found or not published
        if (!$page) {
            // If we're looking for a translation, check if the page exists in another language
            if ($translationUnavailable || $request->has('language')) {
                // Try to find the page in the default language
                $defaultPage = $this->pageService->getPublishedPageBySlug($slug, 'en');
                
                if ($defaultPage) {
                    // Page exists but not in requested language
                    return view('pages.show', [
                        'page' => $defaultPage,
                        'currentPage' => $slug,
                        'metaTitle' => $defaultPage->meta_title ?? $defaultPage->title,
                        'metaDescription' => $defaultPage->meta_description ?? '',
                        'metaKeywords' => $defaultPage->meta_keywords ?? '',
                        'ogImage' => $defaultPage->og_image ?? null,
                        'translationUnavailable' => true,
                        'requestedLanguage' => $language,
                    ]);
                }
            }
            
            abort(404);
        }

        // Eager load media relationships for content blocks
        $page->load('contentBlocks');

        // Pass page data and SEO metadata to view
        return view('pages.show', [
            'page' => $page,
            'currentPage' => $slug,
            'metaTitle' => $page->meta_title ?? $page->title,
            'metaDescription' => $page->meta_description ?? '',
            'metaKeywords' => $page->meta_keywords ?? '',
            'ogImage' => $page->og_image ?? null,
            'translationUnavailable' => false,
        ]);
    }
}
