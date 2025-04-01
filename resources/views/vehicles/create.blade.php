@extends('adminlte::page')
@section('content')
    <div class="container">
        <h1>Add new vehicle</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Something goes wrong!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control" value="{{ old('number') }}"
                       placeholder="Registration number">
                @error('number')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="vin">VIN</label>
                <input type="text" name="vin" class="form-control" value="{{ old('vin') }}" placeholder="VIN Code">
                @error('vin')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_clean" value="0">
                <input type="checkbox" name="is_clean" class="form-check-input" id="is_clean"
                       value="1" {{ old('is_clean') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_clean">Is Clean</label>
                @error('is_clean')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_available_for_rent" value="0">

                <input type="checkbox" name="is_available_for_rent" class="form-check-input" id="is_available_for_rent"
                       value="1" {{ old('is_available_for_rent') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_available_for_rent">Available for Rent</label>
                @error('is_available_for_rent')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_door_opened" value="0">
                <input type="checkbox" name="is_door_opened" class="form-check-input" id="is_door_opened"
                       value="1" {{ old('is_door_opened') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_door_opened">Door is Opened</label>
                @error('is_door_opened')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_in_parking" value="0">
                <input type="checkbox" name="is_in_parking" class="form-check-input" id="is_in_parking"
                       value="1" {{ old('is_in_parking') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_in_parking">In Parking</label>
                @error('is_in_parking')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="rating">Rating</label>
                <input type="number" step="0.1" name="rating" class="form-control" value="{{ old('rating') }}"
                       placeholder="Rating (0 - 5)">
                @error('rating')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="fuel_in_tank">Fuel in Tank</label>
                <input type="number" name="fuel_in_tank" class="form-control" value="{{ old('fuel_in_tank') }}"
                       placeholder="Fuel Level">
                @error('fuel_in_tank')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="location">Location (latitude, longitude)</label>
                <input type="text"
                       class="form-control"
                       id="location"
                       name="location"
                       value="{{ old('location', isset($vehicle) && $vehicle->location ? $vehicle->location->getLatitude()  . ', ' . $vehicle->location->getLongitude() : '') }}"
                       placeholder="Example: 51.5074, -0.1278">
                @error('location')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add vehicle</button>
        </form>
    </div>
@endsection
