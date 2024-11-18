<?php

namespace App\Http\Controllers\Api;

use App\Models\PizzaCategories;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PizzaCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все пиццы из базы данных
        $pizzaCategories = PizzaCategories::get();

        return response()->json($pizzaCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pizza = PizzaCategories::create($request->all());
        return $pizza;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PizzaCategories::find($id);
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
