@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">🗓️ Today’s In-Progress Deliveries — {{ now()->format('l, F j, Y') }}</h2>

    @forelse($orders as $order)
        <div class="card mb-4 shadow border-left border-4 border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5>
                        Order #{{ $order->id }}
                        <span class="badge bg-info text-dark ms-2">In Progress</span>
                    </h5>
                    <span class="text-muted">
                        Scheduled: {{ $order->scheduled_at ? \Carbon\Carbon::parse($order->scheduled_at)->format('H:i') : 'N/A' }}
                    </span>
                </div>

                <p class="mb-1"><strong>Distance:</strong> {{ $order->distance }} km</p>
                <p class="mb-1"><strong>Cost:</strong> ${{ $order->cost }}</p>

                <h6 class="mt-3">📦 Products:</h6>
                <ul class="list-group">
                    @foreach($order->products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Size: {{ $product->width }}×{{ $product->height }} cm |
                            Weight: {{ $product->weight }} kg |
                            Urgency: 
                            <span class="badge bg-{{ 
                                $product->Urgency === 'Urgent' ? 'danger' : 
                                ($product->Urgency === 'Priority' ? 'warning text-dark' : 'secondary') 
                            }}">{{ $product->Urgency }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            📭 No deliveries in progress today.
        </div>
    @endforelse
</div>
@endsection
