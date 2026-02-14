<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect("/cars");
});

Route::resource('cars', CarController::class);

Route::resource('parts', PartController::class);