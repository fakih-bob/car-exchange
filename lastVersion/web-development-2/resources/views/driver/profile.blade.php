@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Driver Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('driver.profile.save') }}">
        @csrf

        <div class="form-group mb-3">
            <label>Plate Number</label>
            <input type="text" name="plate_number" class="form-control" required value="{{ old('plate_number', $driver->plate_number ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Vehicle Type</label>
            <select name="vehicle_type" class="form-control" required>
                @foreach(['sedan', 'suv', 'van', 'truck'] as $type)
                    <option value="{{ $type }}" {{ (old('vehicle_type', $driver->vehicle_type ?? '') == $type) ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>License Number</label>
            <input type="text" name="license_number" class="form-control" required value="{{ old('license_number', $driver->license_number ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>License Expiry</label>
            <input type="date" name="license_expiry" class="form-control" value="{{ old('license_expiry', $driver->license_expiry ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Shift Start</label>
            <input type="time" name="shift_start" class="form-control" value="{{ old('shift_start', $driver->shift_start ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Shift End</label>
            <input type="time" name="shift_end" class="form-control" value="{{ old('shift_end', $driver->shift_end ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label>Working Area</label>
            <input type="text" name="working_area" class="form-control" value="{{ old('working_area', $driver->working_area ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form>
</div>
@endsection
