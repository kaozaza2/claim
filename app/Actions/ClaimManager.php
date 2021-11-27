<?php

namespace App\Actions;

use App\Contracts\ClaimsManager;
use App\Contracts\Ruleable;
use App\Models\Claim;
use Illuminate\Validation\Rule;

class ClaimManager implements ClaimsManager, Ruleable
{
    public function store(array $input)
    {
        return tap(new Claim(), function ($claim) use ($input) {
            $validated = validator($input, $this->rules())
                ->validated();
            $claim->fill($validated);
            $claim->save();
        });
    }

    public function update(Claim $claim, array $input)
    {
        return tap($claim, function ($claim) use ($input) {
            $validated = validator($input, $this->rules())
                ->validated();
            $claim->update($validated);
        });
    }

    public function destroy(Claim $claim): void
    {
        $claim->delete();
    }

    public function rules(): array
    {
        return [
            'equipment_id' => ['required', Rule::exists('equipments', 'id')],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'admin_id' => ['required', Rule::exists('users', 'id')],
            'problem' => ['nullable'],
            'status' => ['required'],
        ];
    }
}
