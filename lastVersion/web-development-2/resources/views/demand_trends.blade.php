@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-4">Demand Trends</h1>

    <!-- Date range selection form -->
    <form method="GET" action="{{ route('demand-trends') }}">
        <div class="mb-4">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date', date('Y-m-d', strtotime('-7 days'))) }}">
        </div>
        <div class="mb-4">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Apply Filters</button>
    </form>

    <!-- Chart container -->
    <canvas id="demandChart" width="400" height="200"></canvas>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare the data for the chart
        const dates = @json($dates);
        const orderCounts = @json($orderCounts);

        // Create the chart
        const ctx = document.getElementById('demandChart').getContext('2d');
        const demandChart = new Chart(ctx, {
            type: 'line',  // You can use 'bar', 'line', etc.
            data: {
                labels: dates,  // Dates on the x-axis
                datasets: [{
                    label: 'Order Counts',
                    data: orderCounts,  // Order counts on the y-axis
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,  // If you want to fill the area under the line chart
                    tension: 0.4  // For smoothness of the line
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
