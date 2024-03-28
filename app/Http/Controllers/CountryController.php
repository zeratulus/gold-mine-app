<?php

namespace App\Http\Controllers;

use App\Classes\WeightUnit;
use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    /**
     * List All countries
     */
    public function index()
    {
        $results = [];
        foreach (Country::all() as $country) {
            $item = $country;
            $item->plan = WeightUnit::getUserFriendlyWeight($country->plan);
            $results[$item->id] = $item;
        }
        return $results;
    }

    /**
     * You may create country using this action. It takes a JSON object containing country name and plan.
     */
    public function store(StoreCountryRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $country = (new Country())->fill($validated);
            $country->save();
            return response($country, Response::HTTP_CREATED);
        }

        return $validated;
    }

    public function show(string $uuid)
    {
        $country = Country::find($uuid);
        if ($country) {
            return response($country, Response::HTTP_OK);
        } else {
            return response(['errors' => 'Country not found'], 404);
        }
    }

    /**
     * You may update country using this action. It takes a JSON object containing country name and plan.
     */
    public function update(UpdateCountryRequest $request, string $uuid)
    {
        $country = Country::find($uuid);
        if (!$country) {
            return response(["errors" => ["id" => "Not found"]], 404);
        }

        $validated = $request->validated();
        if ($validated) {
            $country->fill($validated)->save();
            return response($country, Response::HTTP_OK);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * You may delete country using this action
     */
    public function destroy(string $uuid)
    {
        $country = Country::find($uuid);
        if ($country) {
            $country->delete();
            return response("", 204);
        } else {
            return response(['errors' => 'Country not found'], 404);
        }
    }

}
