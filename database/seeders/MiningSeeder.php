<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Mining;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MiningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mining::factory()
            ->count(fake()->numberBetween(50, 500))
            ->create();
    }
}
