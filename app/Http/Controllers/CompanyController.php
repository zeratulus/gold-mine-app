<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Models\Company;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Company::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $country = (new Company())->fill($validated);
            $country->save();
            return response($country, Response::HTTP_CREATED);
        }

        return $validated;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $country = Company::find($uuid);
        if ($country) {
            return response($country, Response::HTTP_OK);
        } else {
            return response(['errors' => 'Company not found'], 404);
        }
    }

    public function update(UpdateCompanyRequest $request, string $uuid)
    {
        $country = Company::find($uuid);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $country = Company::find($uuid);
        if ($country) {
            $country->delete();
            return response("", 204);
        } else {
            return response(['errors' => 'Company not found'], 404);
        }
    }
}
