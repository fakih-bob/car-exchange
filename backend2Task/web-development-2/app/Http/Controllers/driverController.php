<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Driver;
use App\Models\Order;
use App\Models\DriverReview;
use App\Models\Inbox;
use App\Models\User;
use Auth;
use App\Models\Pricing_model;
use Carbon\Carbon;

use Illuminate\Http\Request;

class driverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllDrivers()
    {
        $drivers = User::where('role', 'driver')
        ->with(['reviewsReceived.client','driver']) 
        ->get();

        return response()->json([
            'status' => true,
            'data' => $drivers
        ]);
    }

    public function getReviews($id){
        $driverReviewed=DriverReview::with('client')->where('driver_id',$id)->get();
        return response()->json([
            'status' =>true,
            'data' =>$driverReviewed
        ]);
    }

    public function getMyInbox(){
            $user=Auth::user();
            if ($user->role !="driver"){
                return response()->json([
                    'Its not a valid Driver'
                ]);
        }
            else{
                $Inboxes=Inbox::where('driver_id',$user->id)->get();
                return response()->json([
                    'status'=>true,
                    'data'=>$Inboxes
                ]);

        }
    }
    public function inboxPage()
    {
        $driver = Auth::user();

        $inboxes = Inbox::with(['order.products'])
            ->where('driver_id', $driver->id)
            ->get();

        return view('driver.inbox', compact('inboxes'));
    }
    public function showProfileForm()
    {
        $driver = Driver::where('user_id', Auth::id())->first();
        return view('driver.profile', compact('driver'));
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|integer',
            'vehicle_type' => 'required|in:sedan,suv,van,truck',
            'license_number' => 'required|string',
            'license_expiry' => 'nullable|date',
            'shift_start' => 'nullable',
            'shift_end' => 'nullable',
            'working_area' => 'nullable|string|max:100',
           
        ]);

        Driver::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'plate_number',
                'vehicle_type',
                'license_number',
                'license_expiry',
                'shift_start',
                'shift_end',
                'working_area',
            ]) + ['status' => 'offline']
        );

        return back()->with('success', 'Driver profile saved successfully!');
    }
   /* public function showDashboard()
    {
        $user = auth()->user(); // logged-in driver

        // Example: Get orders assigned to this driver
        $orders = Order::where('user_id', $user->id)
            ->with('products') // if needed
            ->get();
    
        return view('driver.driverDashboard', compact('orders'));
      
    }*/
    public function dashboardHome()
    {
        return view('driver.dashboard');
    }


    public function DriverDetails()
    {
        return view('DriverDetails');
    }

    public function GetDriverDetails($id)
{
    $driver = Driver::where('user_id', $id)->first();

    if (!$driver) {
        return response()->json(['message' => 'Driver not found'], 404);
    }

    return response()->json(['data' => $driver], 200);
}



    public function showPricingForm()
    {
        $driver = Driver::where('user_id', Auth::id())->first();
        $pricing = $driver ? $driver->pricing_model : null;
        logger("pricing");
        logger($pricing);
        return view('driver.pricing', compact('pricing'));
    }

    public function storePricing(Request $request)
    {
        $request->validate([
            'short_distance_limit' => 'required|numeric',
            'short_distance_price' => 'required|numeric',
            'long_distance_rate' => 'required|numeric',
            'per_volume_rate' => 'required|numeric',
            'per_weight_rate' => 'required|numeric', // 👈 new
        ]);

        $driver = Driver::where('user_id', Auth::id())->firstOrFail();

        Pricing_model::updateOrCreate(
            ['driver_id' => $driver->id],
            $request->only([
                'short_distance_limit',
                'short_distance_price',
                'long_distance_rate',
                'per_volume_rate',
                'per_weight_rate', 
            ])
        );
        return back()->with('success', 'Pricing model saved successfully!');
    }



    public function acceptOrder($id)
    {
        $inbox = Inbox::with('order.products')->findOrFail($id);
        $order = $inbox->order;

        $driverId = Auth::id();

        // 1. Get driver pricing model
        $pricing = Pricing_model::where('driver_id', $driverId)->first();

        if (!$pricing) {
            return back()->with('error', 'Pricing model not found for this driver.');
        }

        // 2. Calculate volume and weight of all products in the order
        $totalVolume = 0;
        $totalWeight = 0;

        foreach ($order->products as $product) {
            $volume = $product->width * $product->height; // optionally * length if available
            $totalVolume += $volume;
            $totalWeight += $product->weight;
        }

        // 3. Fake distance (you can replace with actual logic)
        $distance = rand(5, 30); // in km, replace with real distance if needed

        // 4. Calculate cost based on pricing model
        $volumeCharge = $totalVolume * $pricing->per_volume_rate;
        $weightCharge = $totalWeight * $pricing->per_weight_rate;

        $distanceCharge = $distance <= $pricing->short_distance_limit
            ? $pricing->short_distance_price
            : $distance * $pricing->long_distance_rate;

        $totalCost = round($volumeCharge + $weightCharge + $distanceCharge, 2);

        // 5. Update order
        $order->update([
            'status' => 'accepted',
            'driver_id' => $driverId,
            'cost' => $totalCost
        ]);

        // 6. Remove inbox request
        $inbox->delete();

        return back()->with('success', 'Order accepted and cost calculated: $' . $totalCost);
    }

    public function rejectOrder($id)
    {
        $inbox = Inbox::findOrFail($id);
        $order = $inbox->order;

        $order->delete(); // products cascade-delete due to FK
        $inbox->delete();

        return redirect()->back()->with('success', 'Order rejected and deleted.');
    }
    public function taskDashboard()
    {
        $driver = Auth::user();

        $orders = Order::with('products')
            ->where('driver_id', $driver->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->get();

        return view('driver.tasks', compact('orders'));
    }

    public function updateTaskStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:accepted,in_progress,delivered,canceled',
        ]);
    
        $order->update(['status' => $request->status]);
    
        return back()->with('success', 'Order status updated to ' . $request->status);
    }

   
    public function scheduleDelivery(Request $request, Order $order)
    {
        $request->validate([
            'scheduled_at' => 'required|date',
        ]);
    
        // Only the assigned driver can schedule
        if ($order->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        // Check if the driver already has another delivery at that exact time
        $conflict = Order::where('driver_id', Auth::id())
            ->where('id', '!=', $order->id) // exclude the current order
            ->where('scheduled_at', $request->scheduled_at)
            ->exists();
    
        if ($conflict) {
            return back()->with('error', 'You already have another delivery scheduled at this time. Please choose a different time.');
        }
    
        $order->scheduled_at = $request->scheduled_at;
        $order->save();
    
        return back()->with('success', 'Delivery scheduled successfully!');
    }
    public function orderHistory(Request $request)
    {
        $driverId = Auth::id();
        $statusFilter = $request->input('status'); // optional

        $ordersQuery = Order::where('driver_id', $driverId)
            ->with('products') // if you want to show products too
            ->latest();

        if ($statusFilter) {
            $ordersQuery->where('status', $statusFilter);
        }

        $orders = $ordersQuery->get();

        // Summary Stats
        $summary = [
            'total_accepted' => Order::where('driver_id', $driverId)->where('status', 'accepted')->count(),
            'total_in_progress' => Order::where('driver_id', $driverId)->where('status', 'in_progress')->count(),
            'total_delivered' => Order::where('driver_id', $driverId)->where('status', 'delivered')->count(),
            'total_canceled' => Order::where('driver_id', $driverId)->where('status', 'canceled')->count(),
            'total_earned' => Order::where('driver_id', $driverId)
                                ->where('status', 'delivered')
                                ->sum('cost'),
        ];

        return view('driver.order_history', compact('orders', 'summary', 'statusFilter'));
    }
    public function canceledOrders(Request $request)
    {
        $driverId = Auth::id();

        $orders = Order::with('products')
            ->where('driver_id', $driverId)
            ->where('status', 'canceled');

        // Filter by date range
        if ($request->filled('from')) {
            $orders->whereDate('created_at', '>=', Carbon::parse($request->from));
        }

        if ($request->filled('to')) {
            $orders->whereDate('created_at', '<=', Carbon::parse($request->to));
        }

        $orders = $orders->latest()->get();

        return view('driver.canceled_orders', compact('orders'));
    }
    public function reacceptCanceledOrder(Order $order)
    {
        if ($order->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'canceled') {
            return back()->with('error', 'Only canceled orders can be re-accepted.');
        }

        $order->update([
            'status' => 'accepted'
        ]);

        return back()->with('success', 'Order status changed to accepted.');
    }

}
