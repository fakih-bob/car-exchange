@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-4">Driver Performance</h1>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-light">
        <tr>
            <th class="text-center">Driver Name</th>
            <th class="text-center">Completed Orders</th>
            <th class="text-center">Total Earnings</th>
            <th class="text-center">Rating</th>
        </tr>
        </thead>
        <tbody>
        @foreach($drivers as $driver)
            <tr>
                <td class="text-center">{{ $driver->user ->email }}</td>
                <td class="text-center">{{ $driver->completed_orders_count }}</td>
                <td class="text-center">${{ number_format($driver->total_earnings, 2) }}</td>
                <td class="text-center">{{ $driver->rating ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

