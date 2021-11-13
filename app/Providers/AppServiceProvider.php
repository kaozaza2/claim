<?php

namespace App\Providers;

use App\Actions\CreateDepartment;
use App\Actions\CreateEquipment;
use App\Actions\CreateSubDepartment;
use App\Actions\CreateUser;
use App\Actions\DeleteDepartment;
use App\Actions\DeleteEquipment;
use App\Actions\DeleteSubDepartment;
use App\Actions\DeleteUser;
use App\Actions\PromoteUser;
use App\Actions\UpdateDepartment;
use App\Actions\UpdateEquipment;
use App\Actions\UpdateSubDepartment;
use App\Actions\UpdateUser;
use App\Contracts\CreatesDepartments;
use App\Contracts\CreatesEquipments;
use App\Contracts\CreatesSubDepartments;
use App\Contracts\CreatesUsers;
use App\Contracts\DeletesDepartments;
use App\Contracts\DeletesEquipments;
use App\Contracts\DeletesSubDepartments;
use App\Contracts\DeletesUsers;
use App\Contracts\PromotesUsers;
use App\Contracts\UpdatesDepartments;
use App\Contracts\UpdatesEquipments;
use App\Contracts\UpdatesSubDepartments;
use App\Contracts\UpdatesUsers;
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

        $this->app->singleton(CreatesUsers::class, CreateUser::class);
        $this->app->singleton(PromotesUsers::class, PromoteUser::class);
        $this->app->singleton(UpdatesUsers::class, UpdateUser::class);
        $this->app->singleton(DeletesUsers::class, DeleteUser::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return mixed
     */
    public function boot()
    {
        Validator::extend('identified', function ($attribute, $value, $parameters) {
            if (\strlen($value) !== 13)
                return false;

            $index = 13;
            $value = \str_split($value);
            $calculate = \array_reduce($value, function ($carry, $item) use (&$index) {
                if ($index !== 1)
                    return $carry + ($item * $index--);
                return \substr(11 - ($carry % 11), -1);
            });

            return $calculate === $value[12];
        }, 'The :attribute is not valid ID');

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
