<?php

namespace App\Services;

use App\Classes\WeightUnit;
use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceReportCountries
{
    public function handle(int $month): Collection
    {
        $report = [];

        $countries = Country::all();

        foreach ($countries as $country) {
            $reportPart = DB::table('companies')
                ->leftJoin('countries', 'countries.id', '=', 'companies.country_id')
                ->leftJoin('minings', 'companies.id', '=', 'minings.company_id')
                ->select(['companies.name as name', 'minings.mined as mined', 'countries.plan as plan', 'countries.name as country_name', 'minings.created_at as created_at'])
                ->whereMonth('minings.created_at', '=', date($month))
                ->whereYear('minings.created_at', '=', date('Y'))
                ->where('companies.country_id', '=', $country->id)
                ->get(); //can be implemented with chunk() to process more data with less memory usage with additional calculations

            $totalGrams = $reportPart->sum('mined');

            if ($country->plan <= $totalGrams) {
                $total = WeightUnit::getUserFriendlyWeight($totalGrams);
                $plan = WeightUnit::getUserFriendlyWeight($country->plan);
                $report[$country->id] = [
                    'name' => $country->name,
                    'total' => $total,
                    'totalGrams' => $totalGrams,
                    'plan' => "($plan)"
                ];
            }

        }

        return collect($report)->sortBy('totalGrams', SORT_NUMERIC, true);
    }

}
