<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Dean;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class DeansController extends Controller
{
    public function index()
    {
        $deans = Dean::orderBy('order')->get();

        return view('admin.deans.index', compact('deans'));
    }

    public function edit(Dean $dean)
    {
        return view('admin.deans.edit', compact('dean'));
    }

    public function update(Request $request, Dean $dean)
    {
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'welcome_text' => 'nullable|string',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $dean->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $dean->image,
                true // Use original filename with timestamp
            );
        }

        $dean->full_name = $request->full_name;
        $dean->title = $request->title;
        $dean->position = $request->position;
        $dean->faculty = $request->faculty;
        $dean->welcome_text = $request->welcome_text;
        $dean->education = $request->education;
        $dean->experience = $request->experience;
        $dean->order = $request->order ?? $dean->order;
        $dean->save();

        return redirect()->route('admin.deans.index')->with('success', 'Dean profile updated successfully!');
    }
}
