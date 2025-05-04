<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function CreateDelivery(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'Urgency' => 'required|in:Standard,Priority,Urgent',
            'client_id' => 'required|exists:clients,id',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully.',
            'data' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
