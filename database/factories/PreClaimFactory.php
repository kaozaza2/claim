<?php

namespace Database\Factories;

use App\Models\PreClaim;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreClaimFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PreClaim::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'problem' => $this->faker->words(3, true),
        ];
    }
}
