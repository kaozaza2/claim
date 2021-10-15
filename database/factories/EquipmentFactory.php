<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->numerify('PC-####/##'),
            'brand' => $this->faker->randomElement(['Acer', 'Apple', 'Asus', 'Dell', 'HP', 'Google', 'Lenovo', 'Microsoft', 'Samsung']),
            'category' => $this->faker->randomElement(['จอภาพ', 'เครื่องสำรองไฟ', 'เม้าส์', 'คีย์บอร์ด', 'หูฟัง']),
            'serial_number' => $this->faker->numerify('####-###-#####-###/####'),
            'detail' => $this->faker->words(5, true),
        ];
    }
}
