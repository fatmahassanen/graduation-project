<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class MediaApiController extends Controller
{
    /**
     * Get all events
     */
    public function events(): JsonResponse
    {
        $events = Event::where('is_active', true)
            ->orderBy('event_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get single event
     */
    public function event($id): JsonResponse
    {
        $event = Event::where('is_active', true)->find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Get all gallery items
     */
    public function gallery(): JsonResponse
    {
        $gallery = Gallery::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Get single gallery item
     */
    public function galleryItem($id): JsonResponse
    {
        $item = Gallery::where('is_active', true)->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Get all news
     */
    public function news(): JsonResponse
    {
        $news = News::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get single news item
     */
    public function newsItem($id): JsonResponse
    {
        $item = News::where('is_active', true)->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'News item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }
}
