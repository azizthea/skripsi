<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $role = $user->role;
            
            $request->session()->flash('login_success', 'Selamat datang kembali, ' . $user->name . '!');
            
            if (in_array($role, ['admin', 'bk', 'pengurus'])) {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->intended(route('guru.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak valid.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/portal-kepengasuhan');
    }
}
