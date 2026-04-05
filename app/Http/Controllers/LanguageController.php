<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct(
        protected PageService $pageService
    ) {
    }

    /**
     * Switch the application language and redirect to the translated page.
     */
    public function switch(Request $request, string $lang): RedirectResponse
    {
        // Validate language
        if (!in_array($lang, ['en', 'ar'])) {
            abort(400, 'Invalid language code');
        }

        // Get the current page slug
        $slug = $request->input('slug', '');

        // Store language preference in session
        $request->session()->put('locale', $lang);

        // Set the locale for this request
        app()->setLocale($lang);

        // If no slug provided, redirect to home
        if (empty($slug)) {
            return redirect()->route('home')->with('language_switched', true);
        }

        // Check if the page exists in the target language
        $translatedPage = $this->pageService->getPublishedPageBySlug($slug, $lang);

        if ($translatedPage) {
            // Redirect to the translated page
            return redirect()->route('page.show', ['slug' => $slug, 'language' => $lang])
                ->with('language_switched', true);
        }

        // If translation doesn't exist, redirect to the same page with a message
        return redirect()->route('page.show', ['slug' => $slug, 'language' => $lang])
            ->with('translation_unavailable', true);
    }
}
