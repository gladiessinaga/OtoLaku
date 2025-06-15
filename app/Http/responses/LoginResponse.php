<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'user') {
            return redirect('/user/dashboard');
        }

        // Fallback (kalau tidak ada role)
        return redirect('/dashboard');
    }
}
