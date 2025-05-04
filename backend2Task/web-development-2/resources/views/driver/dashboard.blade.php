@extends('layouts.app')

@section('content')
<style>
    .driver-hero {
        background: linear-gradient(135deg, #1d3557, #457b9d);
        color: white;
        padding: 60px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .driver-hero h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .driver-hero p {
        font-size: 1.1rem;
        margin-top: 10px;
    }

    .card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .card-body{
        min-height: 170px;
    }
</style>

<div class="container">
    {{-- 🧢 Banner --}}
    <div class="driver-hero text-center">
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <p>Your dashboard is ready. Track deliveries, manage your schedule, and stay organized.</p>
    </div>

    {{-- ✅ Dashboard Cards --}}
    <div class="row text-center">
        {{-- View Tasks --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📋 View Tasks</h5>
                    <p class="card-text">See and manage your assigned deliveries.</p>
                    <a href="{{ route('driver.tasks') }}" class="btn btn-outline-primary">Go to Tasks</a>
                </div>
            </div>
        </div>

        {{-- Schedule --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📅 Schedule</h5>
                    <p class="card-text">Update delivery times and manage your calendar.</p>
                    <a href="{{ route('driver.tasks') }}" class="btn btn-outline-success">Manage Schedule</a>
                </div>
            </div>
        </div>

        {{-- Inbox --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">💬 Inbox</h5>
                    <p class="card-text">Check delivery requests and new notifications.</p>
                    <a href="{{ route('driver.inbox') }}" class="btn btn-outline-info">Go to Inbox</a>
                </div>
            </div>
        </div>

        {{-- Profile --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🧑‍💼 Profile</h5>
                    <p class="card-text">Manage your personal and vehicle profile details.</p>
                    <a href="{{ route('driver.profile.form') }}" class="btn btn-outline-dark">Edit Profile</a>
                </div>
            </div>
        </div>

        {{-- Pricing Model --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">💲 Pricing Model</h5>
                    <p class="card-text">Set your delivery rates for distance, volume, and weight.</p>
                    <a href="{{ route('driver.pricing.form') }}" class="btn btn-outline-warning">Manage Pricing</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">❌ Canceled Orders</h5>
                    <p class="card-text">Review and re-accept deliveries you previously canceled.</p>
                    <a href="{{ route('driver.orders.canceled') }}" class="btn btn-outline-danger">View Canceled</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📚 Order History</h5>
                    <p class="card-text">View all your past and current deliveries with earnings summary.</p>
                    <a href="{{ route('driver.orders.history') }}" class="btn btn-outline-secondary">View History</a>
                </div>
            </div>
        </div>

       
    </div>
</div>
@endsection
