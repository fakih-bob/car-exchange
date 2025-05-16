<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\DriverReview;
use App\Models\User;
use Auth;

use Illuminate\Http\Request;

class clientController extends Controller
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
    public function create()
    {
        //
    }
   
    

    public function createReview(Request $request)
{
    $user = Auth::user();

    
    if ($user->role !== 'client') {
        return response()->json(['message' => 'You are not a valid client.'], 403);
    }

    
    $validated = $request->validate([
        'driver_id' => 'required|exists:users,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string',
    ]);

    
    $driver = User::find($validated['driver_id']);
    if ($driver->role !== 'driver') {
        return response()->json(['message' => 'Selected user is not a driver.'], 400);
    }

    
    $review = DriverReview::create([
        'client_id' => $user->id,
        'driver_id' => $validated['driver_id'],
        'rating' => $validated['rating'],
        'review' => $validated['review'] ?? null,
    ]);

    return response()->json([
        'message' => 'Review submitted successfully.',
        'review' => $review
    ], 201);
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
