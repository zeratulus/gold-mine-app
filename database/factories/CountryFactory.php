<?php

namespace Database\Factories;

use App\Classes\WeightUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $weightUnitInt = fake()->numberBetween(0, 2);
        $weightUnit = WeightUnit::intToWeight($weightUnitInt);
        if ($weightUnit == WeightUnit::WU_GRAMS || $weightUnit == WeightUnit::WU_KGS) {
            $planRange = [100, 999];
        } else {
            $planRange = [1, 10];
        }

        return [
            'name' => fake()->country(),
            'plan' => fake()->numberBetween($planRange[0], $planRange[1]),
            'weight_unit' => $weightUnit
        ];
    }
}
