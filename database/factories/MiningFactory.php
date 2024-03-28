<?php

namespace Database\Factories;

use App\Classes\WeightUnit;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mining>
 */
class MiningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::all()->random();

        $planRange = [100, 10000000]; //from 100 grams to 10 tons

        $randomMonth = fake()->numberBetween(1, 6);

        return [
            'company_id' => $company->id,
            'mined' => fake()->numberBetween($planRange[0], $planRange[1]),
            'weight_unit' => WeightUnit::WU_GRAMS,
            'created_at' => Carbon::now()->subMonths($randomMonth)
        ];
    }
}
