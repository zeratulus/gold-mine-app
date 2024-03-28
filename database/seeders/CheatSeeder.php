<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Country;
use App\Models\Mining;
use Database\Factories\MiningFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //This is for sure that all company has 1 mining
        foreach (Company::all() as $company) {
            $miningData = (new MiningFactory)->definition();
            $miningData['id'] = $company->id;
            (new Mining)->fill($miningData)->save();
        }
    }
}
