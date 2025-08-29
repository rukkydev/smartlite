<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
/**
     * Handle an admin login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validate the request
        $this->validateLogin($request);

        // Check rate limiting
        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $credentials = $request->only('email', 'password');

        // Verify admin email domain
        if (!$this->isValidAdminEmail($credentials['email'])) {
            $this->incrementLoginAttempts($request);
            throw ValidationException::withMessages([
                'email' => 'Bad Login method Erron 79!.',
            ]);
        }

        // Attempt to authenticate
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            
            // Update last login information
            $admin->updateLastLogin($request->ip());
            
            // Clear login attempts
            $this->clearLoginAttempts($request);

            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login successful! Redirecting...',
                'user' => [
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'role' => $admin->role,
                ],
                'redirect' => route('admin.dashboard'),
            ], 200);
        }

        // Increment login attempts on failure
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            'email' => 'Invalid login credentials, Please Try Again.',
        ]);
    }

    /**
     * Log the admin out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Successfully logged out.',
            'redirect' => route('admin.login'),
        ], 200);
    }

    /**
     * Validate the login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    }

    /**
     * Check if the email belongs to the admin domain.
     *
     * @param string $email
     * @return bool
     */
    protected function isValidAdminEmail(string $email): bool
    {
        return str_ends_with(strtolower($email), '@adminstrator.com');
    }

    /**
     * Check if there are too many login attempts.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request),
            5 // Maximum attempts
        );
    }

    /**
     * Increment login attempts.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit($this->throttleKey($request), 300); // 5 minutes lockout
    }

    /**
     * Clear login attempts.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Get the throttle key for rate limiting.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function throttleKey(Request $request): string
    {
        return 'login|' . $request->ip() . '|' . $request->input('email');
    }

}