<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admission;
use App\Models\Department;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Training;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'events' => Event::count(),
            'news' => News::count(),
            'departments' => Department::count(),
            'gallery' => Gallery::count(),
            'trainings' => Training::count(),
            'activities' => Activity::count(),

            // Admission Statistics
            'pending_admissions' => Admission::pending()->count(),
            'accepted_admissions' => Admission::accepted()->count(),
            'rejected_admissions' => Admission::rejected()->count(),
        ];

        $recentEvents = Event::latest()->limit(5)->get();
        $recentNews = News::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentNews'));
    }
}
