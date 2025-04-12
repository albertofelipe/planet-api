<?php

namespace App\Http\Controllers;

use App\Filters\Planet\PlanetFilter;
use App\Http\Resources\PlanetResource;
use App\Http\Requests\PlanetRequest;
use App\Http\Requests\PlanetUpdateRequest;
use App\Http\Resources\PlanetCollection;
use App\Models\Planet;
use Illuminate\Http\Request;

class PlanetController extends Controller
{

    public function index(Request $request)
    {
        $filter = new PlanetFilter;

        $query = $filter->transform($request);

        $planets = Planet::where($query)->paginate(10)->appends($request->query());

        return response()->json(new PlanetCollection($planets));
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
