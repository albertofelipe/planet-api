<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanetResource;
use App\Http\Requests\PlanetRequest;
use App\Http\Requests\PlanetUpdateRequest;
use App\Models\Planet;

class PlanetController extends Controller
{

    public function index()
    {
        return Planet::all();
    }

    public function store(PlanetRequest $request)
    {
        $planet = Planet::create($request->validated());

        return response()->json(new PlanetResource($planet));
    }

    public function show(Planet $planet)
    {
        return new PlanetResource($planet);
    }
    
    public function update(PlanetUpdateRequest $request, Planet $planet)
    {
        $planet->update($request->validated());

        return response()->json(new PlanetResource($planet));
    }

    public function destroy(Planet $planet)
    {
        $planet->delete();

        return response()->noContent();
    }
}
