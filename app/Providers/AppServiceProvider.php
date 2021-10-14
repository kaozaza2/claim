<?php

namespace App\Providers;

use App\Http\Middleware\PatchedAttemptToAuthenticate;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\AttemptToAuthenticate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AttemptToAuthenticate::class, PatchedAttemptToAuthenticate::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('any', function ($haystacks, $callback) {

            if ($haystacks instanceof Arrayable) {
                $haystacks = $haystacks->toArray();
            }

            foreach ($haystacks as $haystack) {
                if ($callback($haystack)) {
                    return true;
                }
            }
            return false;
        });
    }
}
