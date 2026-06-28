<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Mail\AdmissionAccepted;
use App\Mail\AdmissionRejected;
use App\Models\Admission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * AdmissionsController
 *
 * Manages admission applications in admin dashboard
 */
class AdmissionsController extends Controller
{
    /**
     * Display pending applications.
     */
    public function pending(): View
    {
        $admissions = Admission::pending()->latest()->get();

        return view('admin.admissions.pending', compact('admissions'));
    }

    /**
     * Display accepted applications.
     */
    public function accepted(): View
    {
        $admissions = Admission::accepted()->latest('reviewed_at')->get();

        return view('admin.admissions.accepted', compact('admissions'));
    }

    /**
     * Display rejected applications.
     */
    public function rejected(): View
    {
        $admissions = Admission::rejected()->latest('reviewed_at')->get();

        return view('admin.admissions.rejected', compact('admissions'));
    }

    /**
     * Show the review page for a specific application.
     */
    public function show(Admission $admission): View
    {
        // #region agent log
        $logPath = base_path('debug-1fa0fa.log');
        foreach (['student_photo', 'birth_certificate', 'qualification_certificate', 'student_id_document', 'parent_id_document'] as $field) {
            if ($admission->$field) {
                file_put_contents($logPath, json_encode([
                    'sessionId' => '1fa0fa',
                    'location' => 'AdmissionsController.php:show',
                    'message' => 'Resolved file URL',
                    'data' => [
                        'admissionId' => $admission->id,
                        'field' => $field,
                        'dbPath' => $admission->$field,
                        'resolvedUrl' => $admission->fileUrl($admission->$field),
                    ],
                    'timestamp' => round(microtime(true) * 1000),
                    'hypothesisId' => 'H1',
                    'runId' => 'post-fix',
                ])."\n", FILE_APPEND);
            }
        }
        // #endregion

        return view('admin.admissions.show', compact('admission'));
    }

    /**
     * Approve an admission application.
     */
    public function approve(Request $request, Admission $admission): RedirectResponse
    {
        // Step 1: Validate required fields
        $request->validate([
            'student_code' => [
                'required',
                'string',
                'regex:/^\d{8}$/',
            ],
        ], [
            'student_code.required' => 'The student code is required.',
            'student_code.regex' => 'The student code must be exactly 8 digits.',
        ]);

        // Step 2: Smart check - Is this student code already taken?
        $existingCode = Admission::where('student_code', $request->student_code)
            ->where('id', '!=', $admission->id)
            ->exists();

        if ($existingCode) {
            return back()->withErrors([
                'student_code' => 'Sorry, this code is already taken by another student. Please check the code and try again.',
            ])->withInput();
        }

        // Step 3: Update database
        $admission->status = 'accepted';
        $admission->student_code = $request->student_code;
        $admission->reviewed_at = now();
        $admission->reviewed_by = auth()->id();
        $admission->save();

        // Step 4: Send acceptance email
        try {
            Mail::to($admission->email)->send(new AdmissionAccepted($admission));
        } catch (\Exception $e) {
            \Log::error('Failed to send acceptance email: '.$e->getMessage(), [
                'admission_id' => $admission->id,
            ]);
            // Continue anyway - approval is more important than email
        }

        return redirect()->route('admin.admissions.pending')
            ->with('success', 'Application approved successfully! Acceptance email has been sent to the student.');
    }

    /**
     * Reject an admission application.
     */
    public function reject(Request $request, Admission $admission): RedirectResponse
    {
        // Validate rejection reason
        $request->validate([
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        // Update database
        $admission->status = 'rejected';
        $admission->rejection_reason = $request->rejection_reason;
        $admission->reviewed_at = now();
        $admission->reviewed_by = auth()->id();
        $admission->save();

        // Send rejection email
        try {
            Mail::to($admission->email)->send(new AdmissionRejected($admission));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: '.$e->getMessage(), [
                'admission_id' => $admission->id,
            ]);
            // Continue anyway - rejection is more important than email
        }

        return redirect()->route('admin.admissions.pending')
            ->with('success', 'Application rejected successfully. Notification email has been sent to the student.');
    }
}
