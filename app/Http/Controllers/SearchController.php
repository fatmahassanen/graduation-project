<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {
    }

    /**
     * Display search results.
     */
    public function index(Request $request): View
    {
        // Validate search query
        $request->validate([
            'q' => 'required|string|min:2|max:500',
            'category' => 'nullable|string',
            'language' => 'nullable|string|in:en,ar',
            'content_type' => 'nullable|string|in:pages,news,events',
        ]);

        $query = $request->input('q');
        $filters = [
            'category' => $request->input('category'),
            'language' => $request->input('language', app()->getLocale()),
            'content_type' => $request->input('content_type'),
        ];

        // Perform search
        $results = $this->searchService->search($query, $filters);

        return view('search.results', [
            'query' => $query,
            'results' => $results,
            'filters' => $filters,
            'currentPage' => 'search',
        ]);
    }
}
