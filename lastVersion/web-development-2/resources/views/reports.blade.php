@extends('layouts.app')

@section('content')
    <div class="container my-5 py-5 px-4 bg-dark rounded shadow-lg text-center">
        <h1 class="text-white mb-5 display-4 fw-bold">Reports</h1>

        <div class="row justify-content-center g-4">
            <div class="col-md-6 col-lg-4">
                <form action="{{ route('total-earnings') }}" method="get">
                    @csrf
                    <button type="submit" class="report-btn bg-success text-dark">
                        Total Earnings
                    </button>
                </form>
            </div>
            <div class="col-md-6 col-lg-4">
                <form action="{{ route('driver-performance') }}" method="get">
                    @csrf
                    <button type="submit" class="report-btn bg-primary text-white">
                        Driver Performance
                    </button>
                </form>
            </div>
            <div class="col-md-6 col-lg-4">
                <form action="{{ route('client-spending') }}" method="get">
                    @csrf
                    <button type="submit" class="report-btn bg-purple text-white">
                        Client Spending
                    </button>
                </form>
            </div>
            <div class="col-md-6 col-lg-4">
                <form action="{{ route('demand-trends') }}" method="get">
                    @csrf
                    <button type="submit" class="report-btn bg-danger text-white">
                        Demand Trends
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .report-btn {
            width: 100%;
            height: 150px;
            font-size: 1.5rem;
            font-weight: 600;
            border: none;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .report-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .bg-purple {
            background-color: mediumpurple !important;
        }
    </style>
@endsection
