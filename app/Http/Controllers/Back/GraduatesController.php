<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GraduatesController extends Controller
{
    public function index()
    {
        $graduates = Graduate::orderBy('order')->orderBy('created_at', 'desc')->get();
        $heroImage = SiteSetting::get('graduates_hero_image', asset('img/kk.png'));
        $heroTitle = SiteSetting::get('graduates_hero_title', 'Outstanding Students at New Cairo Technological University');

        return view('admin.graduates.index', compact('graduates', 'heroImage', 'heroTitle'));
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
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads'), $filename);
            $graduate->image = 'uploads/' . $filename;
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
            // Delete old image if exists
            if ($graduate->image && file_exists(public_path($graduate->image))) {
                unlink(public_path($graduate->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads'), $filename);
            $graduate->image = 'uploads/' . $filename;
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
        // Delete image if exists
        if ($graduate->image && file_exists(public_path($graduate->image))) {
            unlink(public_path($graduate->image));
        }

        $graduate->delete();

        return redirect()->route('admin.graduates.index')->with('success', 'Graduate achievement deleted successfully!');
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_image' => 'required|string',
            'hero_title' => 'required|string',
        ]);

        SiteSetting::set('graduates_hero_image', $request->hero_image);
        SiteSetting::set('graduates_hero_title', $request->hero_title);

        return redirect()->route('admin.graduates.index')->with('success', 'Hero section updated successfully!');
    }
}
