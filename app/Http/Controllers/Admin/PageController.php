<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\PageService;
use App\Services\RevisionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService,
        protected RevisionService $revisionService
    ) {
        $this->middleware('auth');
        $this->authorizeResource(Page::class, 'page');
    }

    /**
     * Display a listing of pages.
     */
    public function index(Request $request): View
    {
        $query = Page::with(['creator', 'updater']);

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

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        // Apply faculty admin scope
        if ($request->user()->isFacultyAdmin()) {
            $query->where('category', $request->user()->faculty_category);
        }

        $pages = $query->orderBy('updated_at', 'desc')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {
        $page = $this->pageService->createPage(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page): View
    {
        $page->load(['contentBlocks', 'revisions.user']);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $this->pageService->updatePage(
            $page,
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Publish the specified page.
     */
    public function publish(Request $request, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('publish', $page);

        $this->pageService->publishPage($page, $request->user());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Page published successfully.',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Page published successfully.');
    }

    /**
     * Unpublish the specified page.
     */
    public function unpublish(Request $request, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('publish', $page);

        $this->pageService->unpublishPage($page, $request->user());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Page unpublished successfully.',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Page unpublished successfully.');
    }

    /**
     * Archive the specified page.
     */
    public function archive(Request $request, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $page);

        $this->pageService->archivePage($page, $request->user());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Page archived successfully.',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Page archived successfully.');
    }
}
