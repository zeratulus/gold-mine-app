<?php

namespace App\Services;

use App\Classes\WeightUnit;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceReportCompanies
{
    public function handle(int $month): Collection
    {
        $report = [];

        $companies = Company::all();

        foreach ($companies as $company) {
            $reportPart = DB::table('companies')
                ->leftJoin('minings', 'companies.id', '=', 'minings.company_id')
                ->select(['companies.name as name', 'minings.mined as mined', 'minings.created_at as created_at'])
                ->whereMonth('minings.created_at', '=', date($month))
                ->whereYear('minings.created_at', '=', date('Y'))
                ->where('companies.id', '=', $company->id)
                ->get(); //can be implemented with chunk() to process more data with less memory usage with additional calculations

            $country = Country::find($company->country_id);

            $totalGrams = $reportPart->sum('mined');

            if ($country->plan <= $totalGrams) {
                $total = WeightUnit::getUserFriendlyWeight($totalGrams);
                $plan = WeightUnit::getUserFriendlyWeight($country->plan);

                $report[$country->id][] = [
                    'name' => $company->name,
                    'total' => $total,
                    'totalGrams' => $totalGrams,
                    'plan' => "($plan)"
                ];
            }
        }
        return collect($report)->sortBy('total', SORT_NUMERIC, true);
    }

}
