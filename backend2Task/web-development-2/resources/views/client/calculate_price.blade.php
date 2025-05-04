@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Calculate Delivery Price</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('total'))
        <div class="alert alert-success">Estimated Price: <strong>${{ number_format(session('total'), 2) }}</strong></div>
    @endif

    <form method="POST" action="{{ route('pricing.calculate') }}">
        @csrf

        <div class="mb-3">
            <label for="driver_id">Select Driver:</label>
            <select name="driver_id" class="form-control" required>
                <option value="">-- Select Driver --</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                        {{ $driver->user->name ?? 'Driver #' . $driver->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Distance (km):</label>
            <input type="number" step="0.1" name="distance" class="form-control" value="{{ old('distance') }}" required>
        </div>

        <div class="mb-3">
            <label>Height:</label>
            <input type="number" step="0.01" name="height" class="form-control" value="{{ old('height') }}" required>
        </div>

        <div class="mb-3">
            <label>Width:</label>
            <input type="number" step="0.01" name="width" class="form-control" value="{{ old('width') }}" required>
        </div>

        <div class="mb-3">
            <label>Length:</label>
            <input type="number" step="0.01" name="length" class="form-control" value="{{ old('length') }}" required>
        </div>

        <div class="mb-3">
            <label>Weight (kg):</label>
            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>
</div>
@endsection
