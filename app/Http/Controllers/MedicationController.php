<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Medication;
use App\Models\Supply;
use Illuminate\Http\Request;

class MedicationController extends Controller
{

    public function index()
    {
        $medications = Medication::paginate(10);
        return view('medications.index', [
            'medications' => $medications,
        ]);
    }
    public function show(Medication $medication)
    {

        $supplies = $medication->supplies;

        $unit_cost = 0;

        foreach ($supplies as $supply) {
            $unit_cost += $supply->price * $supply->pivot->quantity_per_unit;
        }

        return view('medications.show', [
            'medication' => $medication,
            'supplies' => $medication->supplies,
            'sale' => $medication->sale,
            'unit_cost' => $unit_cost,
        ]);
    }

    public function create()
    {
        $supplies = Supply::all()->mapWithKeys(function ($item) {
            return [
                $item->id => $item->name
            ];
        })->toArray();
        $unit_codes = Supply::pluck('unit_code', 'id')->toArray();
        return view('medications.create', compact('supplies', 'unit_codes'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'photo' => ['nullable'],
            'supplies' => ['required', 'array'],
            'supplies.*.id' => ['required', 'exists:supplies,id'],
            'supplies.*.quantity' => ['required', 'numeric', 'min:1'],
        ]);

        $medication = Medication::create([
            'name' => $attributes['name'],
            'price' => $attributes['price'],
            'description' => $attributes['description'],
            'photo' => $attributes['photo'] ?? null,
        ]);

        foreach ($attributes['supplies'] as $supply) {
            $medication->supplies()->attach($supply['id'], [
                'quantity_per_unit' => $supply['quantity'],
            ]);
        }

        return redirect('/medications');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect('/medications');
    }

}
