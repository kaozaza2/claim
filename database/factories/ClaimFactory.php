<?php

namespace Database\Factories;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaimFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Claim::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'equipment_id' => Equipment::factory(),
            'user_id' => User::factory(),
            'admin_id' => User::factory(),
            'problem' => $this->faker->words(3, true),
            'status' => $this->faker->randomElement(['กำลังรับเรื่อง', 'กำลังซ่อม', 'เสร็จสิ้น']),
        ];
    }
}
