<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function loginPage() {
        return view('login');
    }

    public function driverListPage(Request $request) {
        return view('driver-list', ['orderId' => $request->query('orderId')]);
    }

    public function driverDetailPage($id) {
        return view('driver-detail');
    }

    public function orderFormPage() {
        return view('order-form');
    }
    public function dashboardPage()
    {
        return view('dashboard');
    }

    
}
