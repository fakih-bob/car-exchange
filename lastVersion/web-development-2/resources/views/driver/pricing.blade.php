@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Driver Pricing Model</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('driver.pricing.save') }}">
        @csrf
        
        <div class="form-group mb-3">
            <label>Short Distance Limit (km)</label>
            <input type="number" name="short_distance_limit" step="0.1" class="form-control" required value="{{ old('short_distance_limit', $pricing->short_distance_limit ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Short Distance Price ($)</label>
            <input type="number" name="short_distance_price" step="0.01" class="form-control" required value="{{ old('short_distance_price', $pricing->short_distance_price ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Long Distance Rate ($/km)</label>
            <input type="number" name="long_distance_rate" step="0.01" class="form-control" required value="{{ old('long_distance_rate', $pricing->long_distance_rate ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Per Volume Rate ($/unit³)</label>
            <input type="number" name="per_volume_rate" step="0.0001" class="form-control" required value="{{ old('per_volume_rate', $pricing->per_volume_rate ?? '') }}">
        </div>
        <div class="form-group mb-3">
            <label>Per Weight Rate ($/kg)</label>
            <input type="number" name="per_weight_rate" step="0.0001" class="form-control"
                value="{{ old('per_weight_rate', $pricing->per_weight_rate ?? '') }}">
        </div>
        

        <button type="submit" class="btn btn-primary">Save Pricing</button>
    </form>
</div>
@endsection
