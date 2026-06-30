<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\SiteSetting;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class GraduatesController extends Controller
{
    public function index()
    {
        $graduates = Graduate::orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('admin.graduates.index', compact('graduates'));
    }

    public function create()
    {
        return view('admin.graduates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $graduate = new Graduate;
        $graduate->title = $request->title;
        $graduate->description = $request->description;
        $graduate->is_active = $request->has('is_active');
        $graduate->order = $request->order ?? 0;

        if ($request->hasFile('image')) {
            $graduate->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped')
            );
        }

        $graduate->save();

        return redirect()->route('admin.graduates.index')->with('success', 'Graduate achievement created successfully!');
    }

    public function edit(Graduate $graduate)
    {
        return view('admin.graduates.edit', compact('graduate'));
    }

    public function update(Request $request, Graduate $graduate)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $graduate->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $graduate->image
            );
        }

        $graduate->title = $request->title;
        $graduate->description = $request->description;
        $graduate->is_active = $request->has('is_active');
        $graduate->order = $request->order ?? $graduate->order;
        $graduate->save();

        return redirect()->route('admin.graduates.index')->with('success', 'Graduate achievement updated successfully!');
    }

    public function destroy(Graduate $graduate)
    {
        ImageProcessor::deleteStoredImage($graduate->image);

        $graduate->delete();

        return redirect()->route('admin.graduates.index')->with('success', 'Graduate achievement deleted successfully!');
    }
}
