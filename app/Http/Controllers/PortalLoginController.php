<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class PortalLoginController extends Controller
{
    public function show()
    {
        return view('auth.portal-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_as' => 'required|in:admin,user',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        $throttleKey = strtolower($request->email).'|'.$request->ip().'|'.$request->login_as;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Coba lagi dalam '.RateLimiter::availableIn($throttleKey).' detik.',
            ])->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $user = Auth::user();
        $loginAsAdmin = $request->login_as === 'admin';

        if ($loginAsAdmin !== $user->isAdmin()) {
            Auth::logout();
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors([
                'email' => $loginAsAdmin
                    ? 'Akun ini tidak memiliki akses administrator.'
                    : 'Akun administrator harus masuk melalui pilihan Admin.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->route($user->isAdmin() ? 'dashboard.usecase' : 'user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
