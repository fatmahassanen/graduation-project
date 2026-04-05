<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        protected NewsService $newsService
    ) {
    }

    /**
     * Display a listing of news articles.
     * Requirements: 14.2, 14.4, 14.5
     */
    public function index(Request $request): View
    {
        $language = $request->get('lang', 'en');
        $category = $request->get('category');

        $news = $this->newsService->getPublishedNews($category, $language);
        $featuredNews = $this->newsService->getFeaturedNews($language, 3);

        $categories = [
            'announcement' => 'Announcement',
            'achievement' => 'Achievement',
            'research' => 'Research',
            'partnership' => 'Partnership',
        ];

        return view('news.index', compact('news', 'featuredNews', 'categories', 'category'));
    }

    /**
     * Display the specified news article.
     * Requirements: 14.2, 14.5
     */
    public function show(Request $request, string $slug): View
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->with(['featuredImage', 'author'])
            ->firstOrFail();

        $relatedNews = $this->newsService->getRelatedNews($news, 5);

        return view('news.show', compact('news', 'relatedNews'));
    }

    /**
     * Generate RSS feed for news articles.
     * Requirements: 14.9
     */
    public function rss(Request $request): Response
    {
        $language = $request->get('lang', 'en');

        $rss = $this->newsService->generateRssFeed($language, 20);

        return response($rss, 200)
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }
}
