<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Cart;
use App\Models\Cartitems;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderCreatingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'address' => 'required|string',
                'comment' => 'nullable|string',
                'listofpizza' => 'required|array',
                'listofpizza.*.id' => 'required|integer|exists:pizzas,id',
                'listofpizza.*.quantity' => 'required|integer|min:1',
                'status' => 'required|integer'
            ]);

            DB::beginTransaction();

            $cart = Cart::create();

            foreach ($validatedData['listofpizza'] as $pizza) {
                Cartitems::create([
                    'cart_id' => $cart->id,
                    'pizza_id' => $pizza['id'],
                    'quantity' => $pizza['quantity'],
                ]);
            }

            $order = Order::create([
                'client_id' => Auth::id(),
                'cart_id' => $cart->id,
                'address' => $validatedData['address'],
                'comment' => $validatedData['comment'] ?? '',
                'status' => $validatedData['status'],
            ]);

            DB::commit();

            return response()->json(['message' => 'success', 'order_id' => $order->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while creating the order. Please try again.'], 500);
        }
    }
}
