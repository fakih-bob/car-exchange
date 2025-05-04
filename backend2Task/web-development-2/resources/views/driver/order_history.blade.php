@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📚 Delivery History</h2>

    {{-- Filter --}}
    <form method="GET" action="{{ route('driver.orders.history') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- All Statuses --</option>
                    @foreach(['pending', 'accepted', 'in_progress', 'delivered', 'canceled'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Orders List --}}
    @forelse($orders as $order)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    Order #{{ $order->id }} — 
                    <span class="badge bg-secondary">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </h5>
                <p><strong>Cost:</strong> ${{ $order->cost }}</p>
                <p><strong>Scheduled At:</strong> 
                    {{ $order->scheduled_at ? \Carbon\Carbon::parse($order->scheduled_at)->toDayDateTimeString() : 'Not scheduled' }}
                </p>
                <p class="mb-0"><strong>Created At:</strong> {{ $order->created_at->toDayDateTimeString() }}</p>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No orders found for this filter.</div>
    @endforelse

    {{-- Summary --}}
    <div class="mt-5 p-4 bg-light border rounded">
        <h4>📊 Summary</h4>
        <ul class="list-group">
            <li class="list-group-item">✅ Accepted Orders: {{ $summary['total_accepted'] }}</li>
            <li class="list-group-item">🚚 In Progress: {{ $summary['total_in_progress'] }}</li>
            <li class="list-group-item">✔️ Delivered: {{ $summary['total_delivered'] }}</li>
            <li class="list-group-item">❌ Canceled: {{ $summary['total_canceled'] }}</li>
            <li class="list-group-item"><strong>💰 Total Earned:</strong> ${{ $summary['total_earned'] }}</li>
        </ul>
    </div>
</div>
@endsection
