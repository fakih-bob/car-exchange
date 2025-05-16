<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;

class reportsController extends Controller
{
    public function index(){
        return view('/reports');

    }
    public function driverPerformance()
    {
        $drivers = Driver::withCount(['orders as completed_orders_count' => function ($query) {
            $query->where('status', 'completed');
        }])
            ->withSum(['orders as total_earnings' => function ($query) {
                $query->where('status', 'completed');
            }], 'cost')
            ->get();
        return view('/driver_performance', ['drivers' => $drivers]);
    }

    public function clientSpending()
    {
        $clients = Client::withCount(['orders as completed_orders_count' => function ($query) {
            $query->where('status', 'completed');
        }])
            ->withSum(['orders as total_spent' => function ($query) {
                $query->where('status', 'completed');
            }], 'cost')
            ->get();

        return view('client_spending', compact('clients'));
    }


    public function demandTrends(Request $request)
    {
        $startDate = $request->input('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $endDate = $request->input('end_date') ?? date('Y-m-d');

        $ordersByDate = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $orderCounts = [];

        foreach ($ordersByDate as $row) {
            $dates[] = $row->date;
            $orderCounts[] = $row->count;
        }

        return view('demand_trends', [
            'dates' => $dates,
            'orderCounts' => $orderCounts,
        ]);
    }


    public function totalEarnings(Request $request)
    {
        $query = Order::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $query -> where('status', '=', 'completed');

        $orders = $query->get();

        $totalEarnings = $orders->sum('cost');

        return view('total_earnings', [
            'totalEarnings' => $totalEarnings,
            'earningsBreakdown' => $orders,
        ]);
    }

}
