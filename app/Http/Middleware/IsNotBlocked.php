<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsNotBlocked
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda diblokir oleh Admin.']);
        }

        return $next($request);
    }
}