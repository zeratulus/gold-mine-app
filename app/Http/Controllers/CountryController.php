<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class CountryController extends Controller
{
    /**
     * TODO: List All countries
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * You may create country using this action. It takes a JSON object containing country name and plan.
     */
    public function store(StoreCountryRequest $request)
    {
        //TODO: Create
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * You may update country using this action. It takes a JSON object containing country name and plan.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        //TODO: Update
    }

    /**
     * You may delete country using this action
     */
    public function destroy(Country $country)
    {
        //TODO: Delete
    }
}
