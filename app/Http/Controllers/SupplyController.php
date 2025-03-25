<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::paginate(10);
        return view('supplies.index', [
            'supplies' => $supplies,
        ]);
    }
    public function show(Supply $supply)
    {
        return view('supplies.show', [
            'supply' => $supply,
            'medication' =>$supply->medication,
        ]);
    }

    public function create()
    {
        return view('supplies.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'stock' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'supplier' => ['required'],
            'entry_date' => ['required', 'date'],
            'expiration_date' => ['required', 'date'],
        ]);

        $supply = Supply::create($attributes);

        return redirect('/supplies');
    }
    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect('/supplies');
    }

}
