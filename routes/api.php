<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanetController;

Route::group([], function() {
    Route::apiResource('planets', PlanetController::class);
});