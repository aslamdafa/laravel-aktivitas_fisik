<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsOrangTua
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'orangtua') {
            // Biarkan akses jalan terus (ke route tujuan)
            return $next($request);
        }

        // Kalau bukan orang tua, redirect ke halaman lain (misal homepage)
        return redirect('/');
    }
}
