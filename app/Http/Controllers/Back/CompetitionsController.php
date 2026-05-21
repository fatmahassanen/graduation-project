<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionsController extends Controller
{
    public function index()
    {
        $competitions = Competition::orderBy('order')->orderBy('created_at', 'desc')->get();
        $videoUrl = SiteSetting::get('competitions_video_url', asset('img/videos/comptions.mp4'));

        return view('admin.competitions.index', compact('competitions', 'videoUrl'));
    }

    public function create()
    {
        return view('admin.competitions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $competition = new Competition;
        $competition->title = $request->title;
        $competition->description = $request->description;
        $competition->date = $request->date;
        $competition->is_active = $request->has('is_active');
        $competition->order = $request->order ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads'), $filename);
            $competition->image = 'uploads/' . $filename;
        }

        $competition->save();

        return redirect()->route('admin.competitions.index')->with('success', 'Competition created successfully!');
    }

    public function edit(Competition $competition)
    {
        return view('admin.competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($competition->image && file_exists(public_path($competition->image))) {
                unlink(public_path($competition->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads'), $filename);
            $competition->image = 'uploads/' . $filename;
        }

        $competition->title = $request->title;
        $competition->description = $request->description;
        $competition->date = $request->date;
        $competition->is_active = $request->has('is_active');
        $competition->order = $request->order ?? $competition->order;
        $competition->save();

        return redirect()->route('admin.competitions.index')->with('success', 'Competition updated successfully!');
    }

    public function destroy(Competition $competition)
    {
        // Delete image if exists
        if ($competition->image && file_exists(public_path($competition->image))) {
            unlink(public_path($competition->image));
        }

        $competition->delete();

        return redirect()->route('admin.competitions.index')->with('success', 'Competition deleted successfully!');
    }

    public function updateVideo(Request $request)
    {
        $request->validate([
            'video_url' => 'required|string',
        ]);

        SiteSetting::set('competitions_video_url', $request->video_url);

        return redirect()->route('admin.competitions.index')->with('success', 'Video URL updated successfully!');
    }
}
