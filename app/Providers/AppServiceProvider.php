<?php

namespace App\Providers;

use App\Actions\CreateDepartment;
use App\Actions\CreateEquipment;
use App\Actions\CreateSubDepartment;
use App\Actions\DeleteDepartment;
use App\Actions\DeleteEquipment;
use App\Actions\DeleteSubDepartment;
use App\Actions\UpdateDepartment;
use App\Actions\UpdateEquipment;
use App\Actions\UpdateSubDepartment;
use App\Contracts\CreatesDepartments;
use App\Contracts\CreatesEquipments;
use App\Contracts\CreatesSubDepartments;
use App\Contracts\DeletesDepartments;
use App\Contracts\DeletesEquipments;
use App\Contracts\DeletesSubDepartments;
use App\Contracts\UpdatesDepartments;
use App\Contracts\UpdatesEquipments;
use App\Contracts\UpdatesSubDepartments;
use App\Http\Middleware\PatchedAttemptToAuthenticate;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Validator;
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
        $this->app->singleton(CreatesDepartments::class, CreateDepartment::class);
        $this->app->singleton(CreatesEquipments::class, CreateEquipment::class);
        $this->app->singleton(CreatesSubDepartments::class, CreateSubDepartment::class);
        $this->app->singleton(UpdatesDepartments::class, UpdateDepartment::class);
        $this->app->singleton(UpdatesEquipments::class, UpdateEquipment::class);
        $this->app->singleton(UpdatesSubDepartments::class, UpdateSubDepartment::class);
        $this->app->singleton(DeletesDepartments::class, DeleteDepartment::class);
        $this->app->singleton(DeletesEquipments::class, DeleteEquipment::class);
        $this->app->singleton(DeletesSubDepartments::class, DeleteSubDepartment::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('identified', function ($attribute, $value, $parameters) {
            if (strlen($value) != 13)
                return false;

            $calculate = (substr($value, 0, 1) * 13)
                + (substr($value, 1, 1) * 12)
                + (substr($value, 2, 1) * 11)
                + (substr($value, 3, 1) * 10)
                + (substr($value, 4, 1) * 9)
                + (substr($value, 5, 1) * 8)
                + (substr($value, 6, 1) * 7)
                + (substr($value, 7, 1) * 6)
                + (substr($value, 8, 1) * 5)
                + (substr($value, 9, 1) * 4)
                + (substr($value, 10, 1) * 3)
                + (substr($value, 11, 1) * 2);

            return 11 - ($calculate % 11) == substr($value, 12, 1);
        }, 'The :attribute id is invalid');

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
