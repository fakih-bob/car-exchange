<?php

namespace App\Http\Controllers;

use App\Models\Loyalty;
use App\Models\Loyalty_order;
use App\Models\Order;
use Illuminate\Http\Request;

class loyaltyController extends Controller
{

    public function listLoyalties(){
        $this->updateLoyalties();
        $obj = Loyalty::all();
        return view('showLoyalties')->with('obj', $obj);
    }
    public function updateLoyalties()
    {
        $completedOrders = Order::where('status', 'completed')->get();

        foreach ($completedOrders as $order) {
            $loyalty = Loyalty::firstOrCreate(['client_id' => $order->client_id]);

            // Avoid double-counting (you can use a flag or check if order already added)
            if (!Loyalty_order::where('order_id', $order->id)->exists()) {
                $km = $order->kilometers;
                $points = 0;

                if ($km <= 50) $points = $km;
                elseif ($km <= 100) $points = $km * 1.2;
                else $points = $km * 1.5;

                $loyalty->total_kilometers += $km;
                $loyalty->points += $points;
                $loyalty->balance = (int)($loyalty-> points/100);
                $loyalty->save();

                // Optional: track processed orders
                Loyalty_order::create([
                    'order_id' => $order->id,
                    'client_id' => $order->client_id,
                ]);
            }
        }
    }

}
