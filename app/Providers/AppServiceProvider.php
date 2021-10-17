<?php

namespace App\Providers;

use App\Actions\CreateEquipments;
use App\Actions\DeleteEquipment;
use App\Actions\UpdateEquipmentsInformation;
use App\Contracts\CreatesEquipments;
use App\Contracts\DeletesEquipments;
use App\Contracts\UpdatesEquipmentsInformation;
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
        $this->registerBinds();
        $this->registerSingletons();
    }

    private function registerBinds()
    {
        $this->app->bind(AttemptToAuthenticate::class, PatchedAttemptToAuthenticate::class);
    }

    private function registerSingletons()
    {
        $this->app->singleton(CreatesEquipments::class, CreateEquipments::class);
        $this->app->singleton(UpdatesEquipmentsInformation::class, UpdateEquipmentsInformation::class);
        $this->app->singleton(DeletesEquipments::class, DeleteEquipment::class);
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
