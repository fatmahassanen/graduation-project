<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaUploadRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {
        $this->middleware('auth');
        $this->authorizeResource(Media::class, 'media');
    }

    /**
     * Display a listing of media files.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = $request->query('search', '');
        $filters = [
            'mime_type' => $request->query('mime_type'),
            'uploaded_by' => $request->query('uploaded_by'),
            'date_from' => $request->query('date_from'),
            'date_to' => $request->query('date_to'),
        ];

        $media = $this->mediaService->searchMedia($query, $filters);

        // Return JSON for AJAX requests (media browser modal)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media,
            ]);
        }

        return view('admin.media.index', compact('media'));
    }

    /**
     * Show the upload form.
     */
    public function create(): View
    {
        return view('admin.media.upload');
    }

    /**
     * Upload a new media file.
     */
    public function store(MediaUploadRequest $request): RedirectResponse|JsonResponse
    {
        $media = $this->mediaService->uploadFile(
            $request->file('file'),
            $request->user()
        );

        // Update alt_text if provided
        if ($request->filled('alt_text')) {
            $media->update(['alt_text' => $request->alt_text]);
        }

        // Return JSON for AJAX uploads
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully.',
                'media' => $media,
            ]);
        }

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified media file.
     */
    public function show(Media $media): View
    {
        return view('admin.media.show', compact('media'));
    }

    /**
     * Remove the specified media file from storage.
     */
    public function destroy(Media $media): RedirectResponse|JsonResponse
    {
        try {
            $this->mediaService->deleteFile($media, auth()->user());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Media file deleted successfully.',
                ]);
            }

            return redirect()
                ->route('admin.media.index')
                ->with('success', 'Media file deleted successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()
                ->back()
                ->withErrors($e->errors());
        }
    }
}
