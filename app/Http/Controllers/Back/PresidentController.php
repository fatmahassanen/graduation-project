<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\PresidentContent;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class PresidentController extends Controller
{
    public function edit()
    {
        $president = PresidentContent::first() ?? new PresidentContent;

        return view('admin.president.edit', compact('president'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'welcome_text' => 'nullable|string',
            'education' => 'nullable|string',
            'postdoctoral' => 'nullable|string',
            'administrative' => 'nullable|string',
        ]);

        $president = PresidentContent::first();

        if (! $president) {
            $president = new PresidentContent;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $president->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $president->image
            );
        }

        $president->full_name = $request->full_name;
        $president->title = $request->title;
        $president->position = $request->position;
        $president->welcome_text = $request->welcome_text;
        $president->education = $request->education;
        $president->postdoctoral = $request->postdoctoral;
        $president->administrative = $request->administrative;
        $president->save();

        return redirect()->route('admin.president.edit')->with('success', 'President content updated successfully!');
    }
}
