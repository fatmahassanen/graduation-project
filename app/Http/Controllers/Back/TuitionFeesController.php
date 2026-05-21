<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TuitionFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * TuitionFeesController
 *
 * Manages tuition fees and academic year settings.
 * Edit-only system for managing fee structures.
 */
class TuitionFeesController extends Controller
{
    /**
     * Display a listing of tuition fees with settings.
     *
     * @return View
     */
    public function index()
    {
        $fees = TuitionFee::orderBy('order')->get();
        $academicYear = SiteSetting::get('academic_year', '2025–2026');
        $announcement = SiteSetting::get('fees_announcement', '');

        return view('admin.tuition-fees.index', compact('fees', 'academicYear', 'announcement'));
    }

    /**
     * Show the form for editing the specified tuition fee.
     *
     * @return View
     */
    public function edit(TuitionFee $tuitionFee)
    {
        return view('admin.tuition-fees.edit', compact('tuitionFee'));
    }

    /**
     * Update the specified tuition fee in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, TuitionFee $tuitionFee)
    {
        $validated = $request->validate([
            'year_range' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $tuitionFee->update([
            'year_range' => $validated['year_range'],
            'amount' => $validated['amount'],
            'order' => $validated['order'] ?? $tuitionFee->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.tuition-fees.index')
            ->with('success', 'Tuition fee updated successfully!');
    }

    /**
     * Update academic year and announcement settings.
     *
     * @return RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string',
            'announcement' => 'nullable|string',
        ]);

        // Store settings using SiteSetting model
        SiteSetting::set('academic_year', $validated['academic_year']);
        SiteSetting::set('fees_announcement', $validated['announcement'] ?? '');

        return redirect()
            ->route('admin.tuition-fees.index')
            ->with('success', 'Academic year settings updated successfully!');
    }
}
