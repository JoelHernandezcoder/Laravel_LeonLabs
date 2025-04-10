<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use App\Models\ProductionLine;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function show(ProductionOrder $order)
    {
        $line = $order->line;
        $productionLines = ProductionLine::pluck('name', 'id');
        return view('production.show', [
            'order' => $order,
            'line' => $line,
            'productionLines' => $productionLines
        ]);
    }

    public function update(Request $request, $order)
    {
        $validated = $request->validate([
            'state' => 'required|in:0,1,2',
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'production_line_id' => ['required', 'exists:production_lines,id'],
        ]);

        $order = ProductionOrder::findOrFail($order);

        // If attempting to set the order to In Progress (1), check that the production line is not in use during the same period.
        if ($validated['state'] == 1) {
            $conflict = ProductionOrder::where('production_line_id', $validated['production_line_id'])
                ->where('state', 1)
                ->where('id', '<>', $order->id)
                ->where(function ($query) use ($validated) {
                    $query->where('start_date', '<=', $validated['end_date'])
                        ->where('end_date', '>=', $validated['start_date']);
                })->exists();

            if ($conflict) {
                return redirect()->back()->withErrors([
                    'production_line_id' => __('messages.Line in use during that time period', [], session('lang','en'))
                ]);
            }
        }

        $order->state = $validated['state'];
        $order->start_date = $validated['start_date'];
        $order->end_date = $validated['end_date'];
        $order->production_line_id = $validated['production_line_id'];
        $order->save();

        return redirect('/production');
    }

}
