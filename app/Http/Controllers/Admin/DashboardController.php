<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Media;
use App\Models\News;
use App\Models\Page;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the admin dashboard with summary statistics.
     */
    public function index(): View
    {
        $statistics = [
            'pages' => Page::count(),
            'events' => Event::count(),
            'news' => News::count(),
            'media' => Media::count(),
        ];

        return view('admin.dashboard', compact('statistics'));
    }
}
