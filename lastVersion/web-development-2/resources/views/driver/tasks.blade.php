@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🚚 Assigned Deliveries</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach($orders as $order)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5>
                    Order #{{ $order->id }}

                    {{-- Order status --}}
                    @php
                        $badgeColor = match($order->status) {
                            'pending' => 'secondary',
                            'accepted' => 'primary',
                            'in_progress' => 'info',
                            'delivered' => 'success',
                            'canceled' => 'danger',
                            default => 'dark'
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>

                    {{-- Paid status --}}
                    @if($order->paid)
                        <span class="badge bg-success ms-2">✅ Paid</span>
                    @else
                        <span class="badge bg-warning text-dark ms-2">💸 Unpaid</span>
                    @endif
                </h5>

                <p><strong>Total Cost:</strong> ${{ $order->cost }}</p>
                <p><strong>Distance:</strong> {{ $order->distance }} km</p>
                <p>
                    <strong>Scheduled At:</strong>
                    {{ $order->scheduled_at ? \Carbon\Carbon::parse($order->scheduled_at)->toDayDateTimeString() : 'Not scheduled yet' }}
                </p>

                <h6 class="mt-3">Products:</h6>
                <ul class="list-group mb-3">
                    @foreach($order->products as $product)
                        <li class="list-group-item">
                            📦 Weight: {{ $product->weight }}kg — 
                            Size: {{ $product->width }} × {{ $product->height }} cm — 
                            Urgency: {{ $product->Urgency }}
                        </li>
                    @endforeach
                </ul>

                <div class="d-flex flex-wrap gap-3">
                    {{-- Task Status Update --}}
                    <form method="POST" action="{{ route('driver.tasks.status', $order->id) }}">
                        @csrf
                        <div class="input-group">
                            <select name="status" class="form-select">
                                @foreach(['accepted', 'in_progress', 'delivered', 'canceled'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary">Update Status</button>
                        </div>
                    </form>

                    {{-- Delivery Schedule --}}
                    <form method="POST" action="{{ route('driver.tasks.schedule', $order->id) }}">
                        @csrf
                        <div class="input-group">
                            <input type="datetime-local" name="scheduled_at"
                                value="{{ $order->scheduled_at ? \Carbon\Carbon::parse($order->scheduled_at)->format('Y-m-d\TH:i') : '' }}"
                                class="form-control">
                            <button class="btn btn-outline-success">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @if($orders->isEmpty())
        <div class="alert alert-info">📭 No active deliveries assigned yet.</div>
    @endif
</div>
@endsection
