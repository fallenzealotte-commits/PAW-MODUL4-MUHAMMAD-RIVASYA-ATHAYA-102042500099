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
     * Pemakaian di route: 'role:admin' atau 'role:admin,mahasiswa'
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login -> arahkan ke halaman login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Role tidak termasuk yang diizinkan -> tolak akses
        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}