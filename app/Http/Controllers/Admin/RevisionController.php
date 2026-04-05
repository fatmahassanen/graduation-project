<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Revision;
use App\Services\RevisionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RevisionController extends Controller
{
    public function __construct(
        protected RevisionService $revisionService
    ) {
        $this->middleware('auth');
    }

    /**
     * Display revision history for a model.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'revisionable_type' => ['required', 'string'],
            'revisionable_id' => ['required', 'integer'],
        ]);

        $revisionableType = $request->query('revisionable_type');
        $revisionableId = $request->query('revisionable_id');

        // Get the model instance
        $model = app($revisionableType)->findOrFail($revisionableId);

        // Authorize view access to the model
        $this->authorize('view', $model);

        $revisions = $this->revisionService->getRevisionHistory($model);

        return view('admin.revisions.index', compact('revisions', 'model'));
    }

    /**
     * Display the specified revision.
     */
    public function show(Revision $revision): View
    {
        $revision->load(['user', 'revisionable']);

        // Authorize view access to the revisionable model
        $this->authorize('view', $revision->revisionable);

        return view('admin.revisions.show', compact('revision'));
    }

    /**
     * Compare two revisions.
     */
    public function compare(Request $request): View
    {
        $request->validate([
            'revision1_id' => ['required', 'integer', 'exists:revisions,id'],
            'revision2_id' => ['required', 'integer', 'exists:revisions,id'],
        ]);

        $revision1 = Revision::with(['user', 'revisionable'])->findOrFail($request->revision1_id);
        $revision2 = Revision::with(['user', 'revisionable'])->findOrFail($request->revision2_id);

        // Authorize view access
        $this->authorize('view', $revision1->revisionable);

        $diff = $this->revisionService->compareRevisions($revision1, $revision2);

        return view('admin.revisions.compare', compact('revision1', 'revision2', 'diff'));
    }

    /**
     * Restore a revision.
     */
    public function restore(Request $request, Revision $revision): RedirectResponse
    {
        // Authorize restore access
        $this->authorize('restore', $revision->revisionable);

        $model = $this->revisionService->restoreRevision($revision, $request->user());

        return redirect()
            ->back()
            ->with('success', 'Revision restored successfully.');
    }
}
