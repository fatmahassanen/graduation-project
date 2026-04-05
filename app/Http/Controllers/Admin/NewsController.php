<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of news articles.
     */
    public function index(Request $request): View
    {
        $query = News::with(['featuredImage', 'author']);

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(NewsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = $request->user()->id;

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        // Set published_at if status is published
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news): View
    {
        $news->load(['featuredImage', 'author']);

        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();

        // Generate slug if title changed and slug not provided
        if ($data['title'] !== $news->title && empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $news->id);
        }

        // Set published_at if status changed to published
        if ($data['status'] === 'published' && $news->status !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    /**
     * Toggle featured status for a news article.
     */
    public function toggleFeatured(Request $request, News $news): JsonResponse|RedirectResponse
    {
        $news->update(['is_featured' => !$news->is_featured]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_featured' => $news->is_featured,
                'message' => $news->is_featured 
                    ? 'News article marked as featured.' 
                    : 'News article unmarked as featured.',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', $news->is_featured 
                ? 'News article marked as featured.' 
                : 'News article unmarked as featured.');
    }

    /**
     * Generate a unique slug from a title.
     */
    protected function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if a slug exists.
     */
    protected function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = News::where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
