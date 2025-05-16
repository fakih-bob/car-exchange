<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Order;
use App\Models\Product;
use App\Models\Driver;
use Illuminate\Support\Facades\View;
use App\Events\NewDeliveryRequest;



class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function createOrderWithProducts(Request $request)
    {
        $validated = $request->validate([
            'distance' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.weight' => 'required|numeric',
            'products.*.height' => 'required|numeric',
            'products.*.width' => 'required|numeric',
            'products.*.urgency' => 'required|in:Standard,Priority,Urgent',
        ]);
    
        $user = auth()->user();
    
        if ($user->role == "driver") {
            return response()->json([
                'message' => 'User is not a Client.'
            ], 400);
        }
    
        $order = Order::create([
            'user_id' => $user->id,
            'distance' => $validated['distance'], // New distance field
        ]);
    
        foreach ($validated['products'] as $productData) {
            Product::create([
                'weight' => $productData['weight'],
                'height' => $productData['height'],
                'width' => $productData['width'],
                'order_id' => $order->id,
                'urgency' => $productData['urgency'],
            ]);
        }
    
        return response()->json([
            'message' => 'Order and products created successfully!',
            'order' => $order,
        ], 201);
    }
    
      
    public function requestDelivery(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'driver_id' => 'required|exists:users,id',
        ]);
    
        $order = Order::with('user')->findOrFail($validated['order_id']);
    
        $driver = User::where('id', $validated['driver_id'])
                      ->where('role', 'driver')
                      ->first();
    
        if (!$driver) {
            return response()->json([
                'message' => 'User is not a valid driver.'
            ], 400);
        }
    
        $existingInbox = Inbox::where('order_id', $validated['order_id'])->first();
    
        if ($existingInbox) {
            return response()->json([
                'message' => 'This order already has a delivery request.'
            ], 400);
        }
    
        $inbox = new Inbox();
        $inbox->order_id = $validated['order_id'];
        $inbox->driver_id = $validated['driver_id'];
        $inbox->message = 'You have a new delivery request from ' . $order->user->name . ' for order #' . $order->id;
        $inbox->type = 'delivery_request';
        $inbox->save();
        
        $order->driver_id = $validated['driver_id'];
        $order->status = 'pending';
        $order->save();
        event(new NewDeliveryRequest($inbox));
        return response()->json([
            'message' => 'Delivery request sent to driver.',
            'data' => $inbox,
        ], 200);
    }
    


    public function getUserOrders()
{
    $user = auth()->user();

    if ($user->role == "driver") {
        return response()->json([
            'message' => 'User is not a Client.'
        ], 400);
    }

    $orders = Order::with(['products','driver'])
        ->where('user_id', $user->id)
        ->get();

    return response()->json([
        'orders' => $orders
    ], 200);
}


public function OrderStatus(){
    return View('OrderStatus');
}
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
