<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Medication;
use App\Models\ProductionOrder;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::paginate(10);

        $sales->each(function ($sale) {
            $sale->time_remaining = $this->calculateTimeRemaining($sale);
        });

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
            'medications.*.id' => ['required', 'exists:medications'],
            'medications.*.quantity' => ['required', 'integer'],
            'medications.*.sub_total' => ['required', 'numeric'],
            'agreed_date' => ['required', 'date'],
        ]);

        $sale = Sale::create([
            'client_id' => $attributes['client_id'],
            'total' => 0,
            'agreed_date' => $attributes['agreed_date'],
        ]);

        foreach ($attributes['medications'] as $medicationData) {
            $medication = Medication::find($medicationData['id']);
            $quantity = $medicationData['quantity'];
            $subTotal = $medicationData['sub_total'];

            $year = now()->year % 100;
            $batchPrefix = strtolower(str_replace(' ', '', $medication->name));
            $latestOrder = ProductionOrder::where('batch', 'like', "{$batchPrefix}-%-{$year}")
                ->orderBy('batch', 'desc')
                ->first();
            $batchNumber = $latestOrder ? intval(substr($latestOrder->batch, strlen($batchPrefix) + 1, 3)) + 1 : 1;
            $batchNumber = str_pad($batchNumber, 3, '0', STR_PAD_LEFT);

            $batch = "{$batchPrefix}-{$batchNumber}-{$year}";

            $productionOrder = ProductionOrder::create([
                'batch' => $batch,
                'sale_id' => $sale->id,
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

        $sale->updateTotal();

        return redirect('/sales');
    }


    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');
    }

    private function calculateTimeRemaining($sale)
    {
        if (is_null($sale->created_at) || is_null($sale->agreed_date)) {
            return [
                'diffInDays' => 0,
                'hours' => 0,
                'minutes' => 0,
                'status' => 'warning',
            ];
        }

        $createdAt = $sale->created_at;
        $agreedDate = $sale->agreed_date;

        $diffInDays = floor($createdAt->diffInDays($agreedDate));
        $hours = $createdAt->diff($agreedDate)->h;
        $minutes = $createdAt->diff($agreedDate)->i;

        if ($createdAt->diffInSeconds($agreedDate) < 0) {
            $status = 'danger';
        } else {
            $status = 'warning';
        }

        return [
            'diffInDays' => $diffInDays,
            'hours' => $hours,
            'minutes' => $minutes,
            'status' => $status,
        ];
    }
}
