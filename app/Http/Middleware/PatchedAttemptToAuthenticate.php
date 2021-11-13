<?php

namespace App\Http\Middleware;

use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class PatchedAttemptToAuthenticate extends AttemptToAuthenticate
{
    /**
     * @return mixed|void
     */
    public function handle($request, $next)
    {
        if (Fortify::$authenticateUsingCallback) {
            return $this->handleUsingCustomCallback($request, $next);
        }

        $request->only(Fortify::username(), 'password');

        $authKey = Fortify::username();
        if ($authKey !== Fortify::email() && \filter_var($request->input($authKey), FILTER_VALIDATE_EMAIL)) {
            $authKey = Fortify::email();
        }

        if ($this->guard->attempt(
            [$authKey => $request->input(Fortify::username()), 'password' => $request->input('password')],
            $request->filled('remember'))
        ) {
            return $next($request);
        }

        $this->throwFailedAuthenticationException($request);
    }
}
