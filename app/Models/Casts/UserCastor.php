<?php

namespace App\Models\Casts;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UserCastor implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return User::find($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value->id;
    }
}
