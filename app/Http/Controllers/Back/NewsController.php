<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                null,
                true // Use original filename with timestamp
            );
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News added successfully!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $news->image,
                true // Use original filename with timestamp
            );
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully!');
    }

    public function destroy(News $news)
    {
        ImageProcessor::deleteStoredImage($news->image);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted!');
    }
}
