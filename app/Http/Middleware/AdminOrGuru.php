<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrGuru
{
    /**
     * Handle an incoming request.
     * Mengizinkan akses untuk admin DAN guru.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, ['admin', 'guru'])) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
