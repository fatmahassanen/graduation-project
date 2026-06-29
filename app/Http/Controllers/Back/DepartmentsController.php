<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Support\ImageProcessor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * DepartmentsController
 *
 * Manages university departments in the admin panel.
 * Edit-only system - no create or delete operations.
 */
class DepartmentsController extends Controller
{
    /**
     * Display a listing of all departments.
     *
     * @return View
     */
    public function index()
    {
        $departments = Department::orderBy('order')->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for editing the specified department.
     *
     * @return View
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $data['image'] = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $department->image
            );
        }

        $department->update($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department updated successfully!');
    }
}
