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

        $weightUnitInt = fake()->numberBetween(0, 2);
        $weightUnit = WeightUnit::intToWeight($weightUnitInt);
        if ($weightUnit == WeightUnit::WU_GRAMS || $weightUnit == WeightUnit::WU_KGS) {
            $planRange = [100, 999];
        } else {
            $planRange = [1, 10];
        }

        $randomMonth = fake()->numberBetween(1, 6);

        return [
            'company_id' => $company->id,
            'mined' => fake()->numberBetween($planRange[0], $planRange[1]),
            'weight_unit' => $weightUnit,
            'created_at' => Carbon::now()->subMonths($randomMonth)
        ];
    }
}
