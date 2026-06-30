<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Support\ImageProcessor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * TrainingsController
 *
 * Manages training programs with single image support.
 */
class TrainingsController extends Controller
{
    /**
     * Display a listing of all trainings.
     *
     * @return View
     */
    public function index()
    {
        $trainings = Training::latest()->get();

        return view('admin.trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new training.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.trainings.create');
    }

    /**
     * Store a newly created training in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'instructor' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'capacity' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'instructor' => $validated['instructor'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'capacity' => $validated['capacity'] ?? null,
            'category' => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Handle single image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400
            );
        }

        Training::create($data);

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training added successfully!');
    }

    /**
     * Show the form for editing the specified training.
     *
     * @return View
     */
    public function edit(Training $training)
    {
        return view('admin.trainings.edit', compact('training'));
    }

    /**
     * Update the specified training in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'instructor' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'capacity' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'instructor' => $validated['instructor'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'capacity' => $validated['capacity'] ?? null,
            'category' => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle single image upload - replace old if new uploaded
        if ($request->hasFile('image')) {
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $training->image
            );
        }

        $training->update($data);

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training updated successfully!');
    }

    /**
     * Remove the specified training from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Training $training)
    {
        // Delete image if exists
        if ($training->image) {
            ImageProcessor::deleteStoredImage($training->image);
        }

        $training->delete();

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training deleted!');
    }
}
