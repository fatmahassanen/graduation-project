<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

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
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped')
            );
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
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $activity->image
            );
        }

        $activity->update($data);

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated successfully!');
    }

    public function destroy(Activity $activity)
    {
        ImageProcessor::deleteStoredImage($activity->image);
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted!');
    }
}
