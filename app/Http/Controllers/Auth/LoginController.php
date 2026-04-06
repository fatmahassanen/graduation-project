<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AccountLockedException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Get the post-login redirect path.
     * Admin users are redirected to the admin dashboard.
     */
    protected function redirectPath(): string
    {
        return '/admin';
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request.
     *
     * @throws AccountLockedException
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if account is locked
        if ($user->isLockedOut()) {
            throw new AccountLockedException();
        }

        // Attempt authentication
        if (!Hash::check($request->password, $user->password)) {
            $user->incrementFailedAttempts();
            
            // Check if account just got locked
            if ($user->isLockedOut()) {
                throw new AccountLockedException();
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Successful login - reset failed attempts
        $user->resetFailedAttempts();
        
        // Log the user in
        Auth::login($user);

        // Return JSON for API requests
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }

        // Redirect to admin dashboard for web requests
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return JSON for API requests
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logout successful',
            ]);
        }

        // Redirect to login page for web requests
        return redirect()->route('admin.login');
    }
}
