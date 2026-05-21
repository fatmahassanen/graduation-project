<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentPortalController extends Controller
{
    /**
     * Show the student portal dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        $admission = Admission::where('user_id', $user->id)->first();

        // Check if admission is a draft or submitted
        $isDraft = $admission && $admission->isDraft();
        $hasSubmittedApplication = $admission && $admission->isSubmitted();

        return view('student.portal', compact('user', 'admission', 'isDraft', 'hasSubmittedApplication'));
    }

    /**
     * Show the profile edit page.
     */
    public function editProfile(): View
    {
        $user = auth()->user();

        return view('student.edit-profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ], [
            'name.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
        ]);

        $user->update($validated);

        return redirect()->route('student.portal')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the change password page.
     */
    public function editPassword(): View
    {
        return view('student.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('student.portal')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Delete the user's admission application (only if pending).
     */
    public function deleteApplication()
    {
        $admission = Admission::where('user_id', auth()->id())->first();

        if (! $admission) {
            return redirect()->route('student.portal')
                ->with('error', 'No application found.');
        }

        // Only allow deletion if status is pending
        if ($admission->status !== 'pending') {
            return redirect()->route('student.portal')
                ->with('error', 'You cannot delete an application that has been reviewed.');
        }

        // Delete uploaded files
        if ($admission->student_photo) {
            \Storage::disk('public')->delete($admission->student_photo);
        }

        $documents = [
            $admission->birth_certificate,
            $admission->qualification_certificate,
            $admission->student_id_document,
            $admission->parent_id_document,
        ];

        foreach ($documents as $document) {
            if ($document) {
                \Storage::disk('public')->delete($document);
            }
        }

        // Delete the admission record
        $admission->delete();

        return redirect()->route('student.portal')
            ->with('success', 'Application deleted successfully. You can submit a new application.');
    }
}
