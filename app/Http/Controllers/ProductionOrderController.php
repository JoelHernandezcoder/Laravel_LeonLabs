<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProductionLine;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function show(ProductionOrder $order)
    {
        $lines = ProductionLine::all();
        return view('production.show', [
            'order' => $order,
            'lines' => $lines
        ]);
    }
}
