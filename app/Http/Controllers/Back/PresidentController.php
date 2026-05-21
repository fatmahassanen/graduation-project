<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\PresidentContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            // Delete old image if exists
            if ($president->image && file_exists(public_path($president->image))) {
                unlink(public_path($president->image));
            }

            // Store new image
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $filename);
            $president->image = 'uploads/' . $filename;
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
