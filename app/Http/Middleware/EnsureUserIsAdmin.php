<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('portal.login');
        }

        abort_unless(auth()->user()->isAdmin(), 403, 'Halaman ini hanya untuk administrator.');

        return $next($request);
    }
}
