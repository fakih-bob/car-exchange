@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📥 Delivery Requests</h2>

    @foreach($inboxes as $inbox)
        <div class="card mb-4 shadow-sm border">
            <div class="card-body">
                <h5 class="card-title">
                    Order #{{ $inbox->order->id }} — ${{ $inbox->order->cost }}
                </h5>
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $inbox->order->status)) }}</p>
                <p><strong>Distance:</strong> {{ $inbox->order->distance }} km</p>
                <p><strong>Message:</strong> {{ $inbox->message ?? 'New delivery request' }}</p>

                <h6 class="mt-3">Products:</h6>
                <ul class="list-group mb-3">
                    @foreach($inbox->order->products as $product)
                        <li class="list-group-item">
                            📦 Weight: {{ $product->weight }}kg |
                            Size: {{ $product->width }}×{{ $product->height }} |
                            Urgency: {{ $product->Urgency }}
                        </li>
                    @endforeach
                </ul>

                <p><strong>Estimated Delivery Price:</strong> ${{ $inbox->delivery_price }}</p>

                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('driver.inbox.accept', $inbox->id) }}">
                        @csrf
                        <button class="btn btn-success">✅ Accept</button>
                    </form>

                    <form method="POST" action="{{ route('driver.inbox.reject', $inbox->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">❌ Reject</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @if($inboxes->isEmpty())
        <div class="alert alert-info">No delivery requests at the moment.</div>
    @endif
</div>
@endsection
