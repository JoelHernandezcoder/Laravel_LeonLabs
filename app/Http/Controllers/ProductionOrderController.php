<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProductionLine;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function index()
    {
        $prod_orders = ProductionOrder::paginate(10);
        return view('production.index', [
            'prod_orders' => $prod_orders,
        ]);
    }

    public function show(ProductionOrder $prod_order)
    {
        $lines = ProductionLine::all();
        return view('production.show', [
            'prod_order' => $prod_order,
            'lines' => $lines
        ]);
    }
}
