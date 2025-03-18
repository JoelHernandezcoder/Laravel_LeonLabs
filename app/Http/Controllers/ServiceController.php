<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProductionOrder;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::paginate(10);
        return view('services.index', [
            'services' => $services,
        ]);
    }
    public function show(Service $service)
    {
        return view('services.show', [
            'service' => $service,
            'batch' =>$service->order->batch,
        ]);
    }

    public function create()
    {
        $orders = ProductionOrder::pluck('batch', 'id')->toArray();

        return view('services.create', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'production_order_id' => ['required', 'integer'],
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'expiration_date' => ['required', 'date'],
        ]);

        $service = Service::create($attributes);

        return redirect('/services');
    }
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect('/services');
    }

    public function pay(Service $service)
    {
        if ($service->expiration_date < now()) {
            $interest = $service->price * 0.5;
            $service->price += $interest;
        }

        $service->update([
            'price' => $service->price,
            'paid' => true,
        ]);
        return redirect('/services');
    }
}
