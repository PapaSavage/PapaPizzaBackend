<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все пиццы из базы данных
        $clients = Order::get();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pizza = Order::create($request->all());
        return $pizza;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(relations: 'client')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json($order);
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
