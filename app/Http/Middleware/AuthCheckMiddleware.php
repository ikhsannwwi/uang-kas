<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Pengguna telah masuk
            return $next($request);
        }

        // Pengguna belum masuk, alihkan ke halaman masuk
        return redirect()->route('admin.login');
    }
}
