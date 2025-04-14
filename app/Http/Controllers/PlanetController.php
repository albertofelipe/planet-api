<?php

namespace App\Http\Controllers;

use App\Exceptions\PlanetNotFoundException;
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

        return response()->json([
            'message' => 'Planet created successfully.',
            'data' => new PlanetResource($planet)
        ], 201);    
    }

    public function show($id)
    {
        $planet = Planet::find($id);

        if (!$planet) throw new PlanetNotFoundException();

        return new PlanetResource($planet);
    }
    
    public function update(PlanetUpdateRequest $request, $id)
    {
        $planet = Planet::find($id);

        if (!$planet) throw new PlanetNotFoundException();

        $planet->update($request->validated());

        return response()->json([
            'message' => 'Planet updated successfully.',
            'data' => new PlanetResource($planet)
        ]);
    }

    public function destroy($id)
    {
        $planet = Planet::find($id);

        if (!$planet) throw new PlanetNotFoundException();

        $planet->delete();

        return response()->json(['message' => 'Planet deleted successfully'], 204);
    }
}
