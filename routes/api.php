<?php

use App\Http\Controllers\Api\PizzaController;
use App\Http\Controllers\Api\PizzaCategoriesController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\OrderCreatingController;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:6',
    ]);


    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $client = Client::Create(
        [
            'id' => $user->id,
            'phone' => $request->phone,
            'name' => $request->name
        ]
    );

    return response()->json($user, 201);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('YourAppName')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-order', [OrderCreatingController::class, 'store']);

    Route::apiResources([
        '/pizzas' => PizzaController::class,
        '/categories' => PizzaCategoriesController::class,
        '/clients' => ClientsController::class,
        '/orders' => OrdersController::class,
    ]);
});
