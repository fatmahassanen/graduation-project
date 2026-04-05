<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentBlockRequest;
use App\Models\ContentBlock;
use App\Models\Page;
use App\Services\ContentBlockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentBlockController extends Controller
{
    public function __construct(
        protected ContentBlockService $contentBlockService
    ) {
        $this->middleware('auth');
        $this->authorizeResource(ContentBlock::class, 'content_block');
    }

    /**
     * Display a listing of content blocks for a page.
     */
    public function index(Request $request, Page $page): View
    {
        $this->authorize('view', $page);

        $contentBlocks = $this->contentBlockService->getBlocksByPage($page);

        return view('admin.content-blocks.index', compact('page', 'contentBlocks'));
    }

    /**
     * Show the form for creating a new content block.
     */
    public function create(Request $request): View
    {
        $pageId = $request->query('page_id');
        $page = $pageId ? Page::findOrFail($pageId) : null;

        if ($page) {
            $this->authorize('update', $page);
        }

        return view('admin.content-blocks.create', compact('page'));
    }

    /**
     * Store a newly created content block in storage.
     */
    public function store(ContentBlockRequest $request): RedirectResponse
    {
        $page = Page::findOrFail($request->page_id);
        $this->authorize('update', $page);

        $block = $this->contentBlockService->createBlock(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Content block created successfully.');
    }

    /**
     * Show the form for editing the specified content block.
     */
    public function edit(ContentBlock $contentBlock): View
    {
        $contentBlock->load('page');

        return view('admin.content-blocks.edit', compact('contentBlock'));
    }

    /**
     * Update the specified content block in storage.
     */
    public function update(ContentBlockRequest $request, ContentBlock $contentBlock): RedirectResponse
    {
        $this->contentBlockService->updateBlock(
            $contentBlock,
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('admin.pages.edit', $contentBlock->page)
            ->with('success', 'Content block updated successfully.');
    }

    /**
     * Remove the specified content block from storage.
     */
    public function destroy(ContentBlock $contentBlock): RedirectResponse
    {
        $page = $contentBlock->page;

        $this->contentBlockService->deleteBlock($contentBlock, auth()->user());

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Content block deleted successfully.');
    }

    /**
     * Reorder content blocks for a page.
     */
    public function reorder(Request $request, Page $page): JsonResponse
    {
        $this->authorize('update', $page);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:content_blocks,id',
        ]);

        $this->contentBlockService->reorderBlocks($page, $request->order);

        return response()->json([
            'success' => true,
            'message' => 'Content blocks reordered successfully.',
        ]);
    }
}
