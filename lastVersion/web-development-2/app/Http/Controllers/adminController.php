<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Order;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = Driver::all();
        return view('manageDrivers')->with('obj', $obj);
    }
    public function listOrders(){
        $obj = Order::all();
        return view('ordersList')->with('obj', $obj);
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
        $driver = Driver::findOrFail($id);
        $driver ->verified = true;
        $driver->save();
        return redirect()->route('admin.index');
    }
    public function update2(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver ->verified = false;
        $driver->save();
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return redirect('admin');
    }
}
