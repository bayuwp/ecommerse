<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRegistration
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->registered) {
            return redirect('register');
        }

        return $next($request);
    }
}

