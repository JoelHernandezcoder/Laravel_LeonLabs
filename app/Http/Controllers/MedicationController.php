<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{

    public function index()
    {
        $medications = Medication::with('sales')->get();
        return view('medications.index', [
            'medications' => $medications,
        ]);
    }
    public function show(Medication $medication)
    {
        return view('medications.show', [
            'medication' => $medication,
            'sale' =>$medication->sale,
        ]);
    }

    public function create()
    {
        return view('medications.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'photo' => ['nullable'],
        ]);

        $medication = Medication::create($attributes);

        return redirect('/medications');
    }
    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect('/medications');
    }

}
