<?php

namespace App\Http\Controllers;

use App\Models\part;
use App\Http\Requests\StoreOrUpdatepartRequest;
use Inertia\Inertia;
use App\Models\Car;
use Illuminate\Http\Request;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Part::query()->with('car');
        if ($request->filled('part_name')) {
            $query->where('name', 'like', '%' . $request->input('part_name') . '%');
        }

        if ($request->filled('cars') && is_array($request->cars)) {
            $query->whereIn('car_id', $request->cars);
        }

        $avalibleCars = Car::orderBy("name", "asc")->get();
        $paginated = $query->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();
        return Inertia::render("Parts/Index", [
            "cars" => $avalibleCars,
            "paginated" => $paginated,
            'initialPartName' => $request->input('part_name'),
            'initialSelectedCars' => $request->input('cars', [])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::all();
        return Inertia::render("Parts/Crud", ['mode' => 'Insert', 'cars' => $cars]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdatepartRequest $request)
    {
        Part::create([
            'name' => $request->input('name'),
            'serialnumber' => $request->input('serialnumber'),
            'car_id' => $request->input('car_id')
        ]);
        $request->session()->flash('success', 'New part created successfully');
        return redirect()->route('parts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(part $part)
    {
        $part->load('car');
        return Inertia::render('Parts/Crud', ['mode' => 'View', 'part' => $part, 'cars' => $part->car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(part $part)
    {
        $cars = Car::all();
        return Inertia::render("Parts/Crud", ['mode' => 'Update', 'part' => $part, 'cars' => $cars]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdatepartRequest $request, part $part)
    {

        $part->update($request->validated());
        return redirect()->route('parts.index')->with('success', 'Part updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(part $part)
    {
        $part->delete();

        return redirect()->route('parts.index')
            ->with('success', 'Part deleted successfully.');
    }
}
