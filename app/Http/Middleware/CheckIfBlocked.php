<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfBlocked
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah diblokir oleh admin.'
            ]);
        }

        return $next($request);
    }
}
