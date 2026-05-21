<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->get();

        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;
        }

        Activity::create($data);

        return redirect()->route('admin.activities.index')->with('success', 'Activity added successfully!');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($activity->image && file_exists(public_path($activity->image))) {
                unlink(public_path($activity->image));
            }
            
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;
        }

        $activity->update($data);

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated successfully!');
    }

    public function destroy(Activity $activity)
    {
        // Delete image if exists
        if ($activity->image && file_exists(public_path($activity->image))) {
            unlink(public_path($activity->image));
        }
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted!');
    }
}
