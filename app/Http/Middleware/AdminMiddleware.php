<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        \abort(403, 'You don\'t have permission to access.');
    }
}
