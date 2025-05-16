@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Total Earnings Report</h2>

        <!-- Summary Card -->
        <div class="card text-white bg-success mb-4">
            <div class="card-body">
                <h4 class="card-title">Total Earnings</h4>
                <p class="card-text display-4">
                    ${{ number_format($totalEarnings, 2) }}
                </p>
            </div>
        </div>

        <!-- Optional Filters (Date range, driver, etc.) -->
        <form method="GET" action="{{ route('total-earnings') }}" class="mb-4 row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <!-- Optional Breakdown Table -->
        @if(isset($earningsBreakdown) && count($earningsBreakdown))
            <h4>Earnings Breakdown</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Driver</th>
                    <th>Client</th>
                    <th>Order ID</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($earningsBreakdown as $record)
                    <tr>
                        <td>{{ $record-> client -> user -> name }}</td>
                        <td>{{ $record-> driver -> user -> name }}</td>
                        <td>{{ $record->id }}</td>
                        <td>${{ number_format($record->cost, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No earnings data available for the selected period.</p>
        @endif
    </div>
@endsection
