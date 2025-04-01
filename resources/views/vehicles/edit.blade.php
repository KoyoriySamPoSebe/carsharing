@extends('adminlte::page')

@section('content')

    <div class="container">
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

        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="number">NUMBER</label>
                <input type="text" class="form-control" id="number" name="number"
                       value="{{ old('number', $vehicle->number) }}" required>
            </div>

            <div class="form-group">
                <label for="vin">VIN</label>
                <input type="text" class="form-control" id="vin" name="vin" value="{{ old('vin', $vehicle->vin) }}"
                       required>
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_clean" value="0">
                <input type="checkbox" name="is_clean" class="form-check-input" id="is_clean"
                       value="1" {{ old('is_clean', $vehicle->is_clean) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_clean">Is Clean</label>
                @error('is_clean')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_available_for_rent" value="0">

                <input type="checkbox" name="is_available_for_rent" class="form-check-input" id="is_available_for_rent"
                       value="1" {{ old('is_available_for_rent', $vehicle->is_available_for_rent) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_available_for_rent">Available for Rent</label>
                @error('is_available_for_rent')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_door_opened" value="0">
                <input type="checkbox" name="is_door_opened" class="form-check-input" id="is_door_opened"
                       value="1" {{ old('is_door_opened', $vehicle->is_door_opened) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_door_opened">Door is Opened</label>
                @error('is_door_opened')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group form-check">
                <input type="hidden" name="is_in_parking" value="0">
                <input type="checkbox" name="is_in_parking" class="form-check-input" id="is_in_parking"
                       value="1" {{ old('is_in_parking', $vehicle->is_in_parking) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_in_parking">In Parking</label>
                @error('is_in_parking')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="rating">RATING</label>
                <input type="number" class="form-control" id="rating" name="rating"
                       value="{{ old('rating', $vehicle->rating) }}" min="0" max="5" step="0.1" required>
            </div>

            <div class="form-group">
                <label for="fuel_in_tank">FUEL</label>
                <input type="number" class="form-control" id="fuel_in_tank" name="fuel_in_tank"
                       value="{{ old('fuel_in_tank', $vehicle->fuel_in_tank) }}" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location"
                       value="{{ old('location', $vehicle->location ? $vehicle->location->getLatitude() . ', ' . $vehicle->location->getLongitude() : '') }}"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
    </div>
@endsection
