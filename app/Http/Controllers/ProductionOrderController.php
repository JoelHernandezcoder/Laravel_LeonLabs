<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProductionLine;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function show(ProductionOrder $prod_order)
    {
        $lines = ProductionLine::all();
        return view('production.show', [
            'prod_order' => $prod_order,
            'lines' => $lines
        ]);
    }
}
