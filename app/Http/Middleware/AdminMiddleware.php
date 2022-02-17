<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        if (optional($request->user())->isAdmin()) {
            return $next($request);
        }

        \abort(403, 'You don\'t have permission to access.');
    }
}
