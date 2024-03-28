<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Mining;
use Database\Factories\MiningFactory;
use Illuminate\Database\Seeder;

class CheatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factory = new MiningFactory();
        //This is for sure that all company has 1 mining each month
        foreach (Company::all() as $company) {
            for ($i = 0; $i < 7; $i++) {
                $miningData = $factory->definition();
                $miningData['company_id'] = $company->id;
                $miningData['created_at'] = date("Y-m-d H:i:s", strtotime("-$i months"));
                (new Mining)->fill($miningData)->save();
            }
        }
    }
}
