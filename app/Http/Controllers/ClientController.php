<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', [
            'clients' => $clients,
        ]);
    }
    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => $client,
            'sales' =>$client->sales,
        ]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'country' => ['required'],
        ]);

        $client = Client::create($attributes);

        return redirect('/clients');
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('/clients');
    }
}
