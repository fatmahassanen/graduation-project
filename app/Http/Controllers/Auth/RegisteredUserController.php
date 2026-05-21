<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\User;
use App\Rules\OfficialEmailProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // If user is already logged in and has an application, redirect to portal
        if (Auth::check()) {
            $admission = Admission::where('user_id', Auth::id())->first();
            if ($admission) {
                return redirect()->route('student.portal');
            }
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                new OfficialEmailProvider,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('admission.create');
        } catch (\Exception $e) {
            \Log::error('User registration failed: '.$e->getMessage());

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}
