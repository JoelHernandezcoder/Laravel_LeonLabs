<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Medication;
use App\Models\ProductionOrder;
use App\Models\ProductionLine;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::paginate(10);

        return view('sales.index', [
            'sales' => $sales,
        ]);
    }

    public function show(Sale $sale)
    {
        $medicationsWithOrders = $sale->medications->map(function ($medication) use ($sale) {
            $medication->orders = $medication->orders()
                ->join('medication_production_order as mpo', 'mpo.production_order_id', '=', 'production_orders.id')
                ->join('production_orders as po', 'po.id', '=', 'mpo.production_order_id')
                ->where('po.sale_id', $sale->id)
                ->get();
            return $medication;
        });

        return view('sales.show', [
            'sale' => $sale,
            'medications' => $medicationsWithOrders,
            'total' => $sale->total,
        ]);
    }

    public function create()
    {
        $clients = Client::pluck('name', 'id')->toArray();
        $medications = Medication::select('id', 'name', 'price')->get()->toArray();

        $medicationOptions = [];
        foreach ($medications as $medication) {
            $medicationOptions[$medication['id']] = $medication['name'];
        }
        $priceOptions = [];
        foreach ($medications as $medication) {
            $priceOptions[$medication['id']] = $medication['price'];
        }

        $orders = ProductionOrder::pluck('batch', 'id')->toArray();

        return view('sales.create', [
            'clients' => $clients,
            'medications' => $medicationOptions,
            'prices' => $priceOptions,
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'medications' => ['required', 'array'],
            'medications.*.id' => ['required', 'exists:medications,id'],
            'medications.*.quantity' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'agreed_date' => ['required', 'date'],
        ]);

        // validate product's lines
        $newOrders = count($attributes['medications']);
        $maxOrders = ProductionLine::count();
        $overlapCount = ProductionOrder::where('start_date', '<=', $attributes['agreed_date'])
            ->where('end_date', '>=', $attributes['start_date'])
            ->count();

        if ($overlapCount + $newOrders > $maxOrders) {
            return back()->withErrors([
                'date' => __('messages.There are not enough production lines available for the selected date range.', [], session('lang', 'en'))
            ])->withInput();
        }


        $sale = Sale::create([
            'client_id' => $attributes['client_id'],
            'agreed_date' => $attributes['agreed_date'],
            'total' => 0,
        ]);

        $total = 0;

        foreach ($attributes['medications'] as $medicationData) {
            $medication = Medication::find($medicationData['id']);
            $quantity = $medicationData['quantity'];
            $subTotal = $medication->price * $quantity;
            $total += $subTotal;

            $year = now()->year % 100;
            $batchPrefix = strtolower(str_replace(' ', '', $medication->name));
            $latestOrder = ProductionOrder::where('batch', 'like', "{$batchPrefix}-%-{$year}")
                ->orderBy('batch', 'desc')
                ->first();
            $batchNumber = $latestOrder ? intval(substr($latestOrder->batch, strlen($batchPrefix) + 1, 3)) + 1 : 1;
            $batchNumber = str_pad($batchNumber, 3, '0', STR_PAD_LEFT);
            $batch = "{$batchPrefix}-{$batchNumber}-{$year}";

            $availableLine = ProductionLine::all()->first(function ($line) use ($attributes) {
                return !$line->orders()
                    ->where(function ($query) use ($attributes) {
                        $query->where('start_date', '<=', $attributes['agreed_date'])
                            ->where('end_date', '>=', $attributes['start_date']);
                    })
                    ->exists();
            });

            if (!$availableLine) {
                return back()->withErrors([
                    'date' => __('messages.No available production lines for one or more medications in the selected date range.', [], session('lang','en')),
                ])->withInput();
            }

            $productionOrder = ProductionOrder::create([
                'batch' => $batch,
                'sale_id' => $sale->id,
                'start_date' => $attributes['start_date'],
                'original_start_date' => $attributes['start_date'],
                'end_date' => $sale->agreed_date,
                'original_end_date' => $sale->agreed_date,
                'production_line_id' => $availableLine->id,
            ]);


            $productionOrder->medications()->attach($medication->id, [
                'quantity' => $quantity,
                'sub_total' => $subTotal,
                'sale_id' => $sale->id,
            ]);

            $sale->medications()->attach($medication->id, [
                'quantity' => $quantity,
                'sub_total' => $subTotal,
                'sale_id' => $sale->id,
            ]);
        }

        $sale->update(['total' => $total]);

        return redirect('/sales');
    }

    public function destroy(Sale $sale)
    {
        $sale->medications()->detach();
        $sale->delete();
        return redirect('/sales');
    }
}
