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
        $planRange = [100, 10000000]; //from 100 grams to 10 tons

        return [
            'name' => fake()->country(),
            'plan' => fake()->numberBetween($planRange[0], $planRange[1]),
            'weight_unit' => WeightUnit::WU_GRAMS
        ];
    }
}
