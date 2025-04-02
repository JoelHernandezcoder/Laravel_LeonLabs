<?php

namespace App\Http\Controllers;


use App\Models\ProductionLine;
use Illuminate\Http\Request;

class ProductionLineController extends Controller
{
    public function index()
    {
        $lines = ProductionLine::all();
        return view('production.lines.index', [
            'lines' => $lines,
        ]);
    }
    public function show(ProductionLine $line)
    {
        return view('production.lines.show', [
            'line' => $line,
            'employees' =>$line->employees,
        ]);
    }
}
