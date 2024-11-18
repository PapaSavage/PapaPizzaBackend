<?php

use App\Http\Controllers\Api\PizzaController;
use App\Http\Controllers\Api\PizzaCategoriesController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\OrderCreatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-order', [OrderCreatingController::class, 'store']);

Route::apiResources([
    '/pizzas' => PizzaController::class,
    '/categories' => PizzaCategoriesController::class,
    '/clients' => ClientsController::class,
    '/orders' => OrdersController::class,
]);
