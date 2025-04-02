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
    public function updateState(Request $request, $order)
    {
        $validated = $request->validate([
            'state' => 'required|in:0,1,2'
        ]);

        $order = ProductionOrder::findOrFail($order);
        $order->state = $validated['state'];
        $order->save();

        return redirect('/production');
    }

    public function updateLineDates(Request $request, $order)
    {
        $validated = $request->validate([
            'start_date'=> ['required'],
            'end_date'=> ['required'],
            'production_line_id'=> ['required'],
        ]);

        $order = ProductionOrder::find($order);
        $order->start_date = $validated['start_date'];
        $order->end_date= $validated['end_date'];
        $order->production_line_id= $validated['production_line_id'];
        $order->save();

        return redirect('/production');
    }


}
