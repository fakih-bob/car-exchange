@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Client Spending Report</h1>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                <tr>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Completed Orders</th>
                    <th>Total Spent</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client-> user -> name }}</td>
                        <td>{{ $client-> user -> email }}</td>
                        <td>{{ $client->completed_orders_count }}</td>
                        <td>${{ number_format($client->total_spent, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No client data available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
