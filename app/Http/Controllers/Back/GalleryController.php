<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('order')->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Upload image to public/img
        $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('uploads'), $filename);

        // Auto-generate title from filename if not provided
        $title = $request->title;
        if (empty($title)) {
            $title = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $title = ucwords(str_replace(['-', '_'], ' ', $title));
        }

        // Auto-increment order
        $maxOrder = Gallery::max('order') ?? 0;

        $data = [
            'title' => $title,
            'description' => null,
            'image' => 'uploads/' . $filename,
            'category' => $request->category,
            'order' => $maxOrder + 1,
            'is_active' => $request->boolean('is_active', true),
        ];

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded successfully!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title ?: $gallery->title,
            'category' => $request->category,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }
            
            // Upload new image to public/img
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;

            // Auto-generate title from new filename if title is empty
            if (empty($data['title'])) {
                $data['title'] = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                $data['title'] = ucwords(str_replace(['-', '_'], ' ', $data['title']));
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully!');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image if exists
        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted!');
    }
}
