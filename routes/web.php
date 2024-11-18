<?php

use App\Http\Controllers\Api\PizzaController;
use App\Http\Controllers\Api\OrderCreatingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});

// Route::get(uri:'/api/pizzas', action: [PizzaController::class, 'index']);


Route::get('/token', function (Request $request) {
    // $token = $request->session()->token();
 
    $token = csrf_token();
 
    return $token;
});