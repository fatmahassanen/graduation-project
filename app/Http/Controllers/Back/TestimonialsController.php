<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Support\ImageProcessor;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * TestimonialsController
 *
 * Manages graduate testimonials and success stories.
 * Edit-only system with drag-and-drop reordering capability.
 */
class TestimonialsController extends Controller
{
    use HandlesImageUploads;

    /**
     * Display a listing of all testimonials.
     *
     * @return View
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for editing the specified testimonial.
     *
     * @return View
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'testimonial' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'student_name' => $validated['student_name'],
            'department' => $validated['department'] ?? null,
            'testimonial' => $validated['testimonial'],
            'order' => $validated['order'],
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $data['photo'] = ImageProcessor::storeUploadedImage(
                $request->file('photo'),
                $request->boolean('photo_cropped'),
                400,
                $testimonial->photo
            );
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Update the display order of testimonials via AJAX.
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|exists:testimonials,id',
            'testimonials.*.order' => 'required|integer|min:0',
        ]);

        // Bulk update testimonial order
        foreach ($validated['testimonials'] as $item) {
            Testimonial::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }
}
