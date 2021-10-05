<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubDepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubDepartment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'department_id' => Department::factory(),
            'name' => $this->faker->company(),
        ];
    }
}
