<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreOrUpdateCarRequest;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $paginated = $query->orderBy('created_at', 'desc')->paginate(10);
        return Inertia::render("Cars/Index", ["paginated" => $paginated, "search" => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Cars/Crud", ['mode' => 'Insert']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateCarRequest $request)
    {
        Car::create([
            'name'  => $request->input('name'),
            'registration_number' => $request->input('registration_number'),
            'is_registered'  => $request->input('is_registered'),

        ]);
        $request->session()->flash('success', "Car " . $request->input('name') . " created successfully!");

        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load('parts');
        return Inertia::render("Cars/Crud", ['mode' => 'View', 'car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car->load('parts');
        return Inertia::render("Cars/Crud", ['mode' => 'Update', 'car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return redirect()->route('cars.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully.');
    }
}
