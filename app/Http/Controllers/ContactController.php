<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    /**
     * Store a contact form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'g-recaptcha-response' => 'nullable|string', // reCAPTCHA token
        ]);

        // Validate reCAPTCHA if configured
        if (config('services.recaptcha.secret_key')) {
            $this->validateRecaptcha($request->input('g-recaptcha-response'));
        }

        // Rate limiting: max 3 submissions per hour per IP
        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'rate_limit' => "Too many submissions. Please try again in {$seconds} seconds."
            ])->withInput();
        }

        RateLimiter::hit($key, 3600); // 1 hour

        // Store the submission
        $submission = ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send email notification
        $this->sendEmailNotification($submission);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    /**
     * Validate reCAPTCHA response.
     */
    protected function validateRecaptcha(?string $token): void
    {
        if (!$token) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'g-recaptcha-response' => 'Please complete the reCAPTCHA verification.'
            ]);
        }

        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();

        if (!$result['success'] ?? false) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }
    }

    /**
     * Send email notification to admin.
     */
    protected function sendEmailNotification(ContactSubmission $submission): void
    {
        try {
            $adminEmail = config('mail.admin_email', config('mail.from.address'));

            Mail::send('emails.contact-submission', ['submission' => $submission], function ($message) use ($adminEmail, $submission) {
                $message->to($adminEmail)
                    ->subject('New Contact Form Submission: ' . $submission->subject);
            });
        } catch (\Exception $e) {
            // Log the error but don't fail the submission
            \Illuminate\Support\Facades\Log::error('Failed to send contact form email: ' . $e->getMessage());
        }
    }
}
