@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">❌ Canceled Deliveries</h2>

    {{-- Filters --}}
    <form method="GET" action="{{ route('driver.orders.canceled') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label>From:</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-4">
            <label>To:</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('driver.orders.canceled') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Order Cards --}}
    @forelse($orders as $order)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5>Order #{{ $order->id }} — <span class="badge bg-danger">Canceled</span></h5>
                <p><strong>Cost:</strong> ${{ $order->cost }}</p>
                <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Scheduled At:</strong> {{ $order->scheduled_at ?? 'Not scheduled' }}</p>

                <h6>Products:</h6>
                <ul class="list-group mb-3">
                    @foreach($order->products as $product)
                        <li class="list-group-item">
                            📦 Weight: {{ $product->weight }}kg | Size: {{ $product->width }}×{{ $product->height }} | Urgency: {{ $product->Urgency }}
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('driver.orders.reaccept', $order->id) }}">
                    @csrf
                    <button class="btn btn-success">✅ Re-Accept Order</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No canceled orders in this range.</div>
    @endforelse
</div>
@endsection
