<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsGuru
{
     public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'guru') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya untuk guru');
    }
}
