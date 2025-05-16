@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- 🎉 Hero Banner -->
        <div class="dashboard-hero">
            <h1>Welcome to the Dashboard</h1>
            <p>Choose an action below to manage your workflow efficiently.</p>
        </div>

        <!-- 📦 Action Cards -->
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🚗 View Drivers</h5>
                        <p class="card-text">Browse all registered drivers and their details.</p>
                        <button onclick="goToDrivers()" class="btn btn-outline-primary">Go to Drivers</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">📝 Create Order</h5>
                        <p class="card-text">Start a new delivery request and assign details.</p>
                        <button onclick="goToOrderForm()" class="btn btn-outline-success">Create Order</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">📦 Show Orders</h5>
                        <p class="card-text">View, track, or update existing orders.</p>
                        <button onclick="goToOrders()" class="btn btn-outline-info">View Orders</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">📅 Calendar</h5>
                        <p class="card-text">Check upcoming tasks, schedules, and delivery timelines.</p>
                        <button onclick="goToCalendar()" class="btn btn-outline-warning">View Calendar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function goToDrivers() {
            window.location.href = "/drivers";
        }

        function goToOrderForm() {
            window.location.href = "/order-form";
        }

        function goToOrders() {
            window.location.href = "/OrderStatus";
        }

        function goToCalendar() {
            window.location.href = "/calendar";
        }
    </script>
@endsection

@section('styles')
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: white;
            padding: 60px 30px;
            border-radius: 12px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .dashboard-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .dashboard-hero p {
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-body {
            min-height: 160px;
        }
    </style>
@endsection
