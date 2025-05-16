@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow rounded-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Client Loyalty Points</h4>
            </div>

            <div class="card-body p-4">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>Client Name</th>
                        <th>Total Kilometers</th>
                        <th>Total Points</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($obj as $loy)
                        <tr>
                            <td>{{ $loy->client->user->name }}</td>
                            <td>{{ $loy->total_kilometers }} km</td>
                            <td style="color: red; font-weight: bold">{{ $loy->points }} pts</td>
                            <td style="color: green; font-weight: bold">${{ $loy->balance }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
