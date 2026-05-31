<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check() || !in_array(\Illuminate\Support\Facades\Auth::user()->role, $roles)) {
            abort(403, 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
