<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все пиццы из базы данных
        $clients = Client::with(relations: 'orders')->get();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pizza = Client::create($request->all());
        return $pizza;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::with('orders')->find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json($client);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
