<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Memeriksa role user sebelum mengizinkan akses ke route tertentu.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            // Jika guru mencoba akses admin, redirect ke dashboard guru
            if (auth()->user()->role === 'guru') {
                return redirect()->route('guru.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            // Mencegah infinite redirect loop
            if ($request->route()->getName() === 'dashboard') {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
