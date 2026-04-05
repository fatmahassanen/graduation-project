<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of contact submissions.
     */
    public function index(Request $request): View
    {
        $query = ContactSubmission::with('reader');

        // Apply filters
        if ($request->filled('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%')
                    ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        // Order by most recent first, unread first
        $submissions = $query
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.contacts.index', compact('submissions'));
    }

    /**
     * Display the specified contact submission.
     */
    public function show(ContactSubmission $contact): View
    {
        $contact->load('reader');

        // Automatically mark as read when viewed
        if (!$contact->is_read) {
            $contact->markAsRead(auth()->id());
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark a contact submission as read.
     */
    public function markAsRead(Request $request, ContactSubmission $contact): JsonResponse|RedirectResponse
    {
        $contact->markAsRead($request->user()->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contact submission marked as read.',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Contact submission marked as read.');
    }

    /**
     * Delete a contact submission.
     */
    public function destroy(ContactSubmission $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contact submission deleted successfully.');
    }
}
