<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form class="form-inline">
                <input
                    wire:model.live="searchValue"
                    type="text"
                    class="form-control mr-2"
                    placeholder="Search by VIN or number"
                    id="search"
                    name="search"
                >
                <a href="{{ route('vehicles.create') }}" class="btn btn-success ml-2">ADD VEHICLE</a>

            </form>
        </div>
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>NUMBER</th>
                    <th>VIN</th>
                    <th>CLEAN</th>
                    <th>AVAILABLE FOR RENT</th>
                    <th>DOOR IS OPEN</th>
                    <th>IN PARKING</th>
                    <th>RATING</th>
                    <th>FUEL</th>
                    <th>LOCATION</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>{{ $vehicle->number }}</td>
                        <td>{{ $vehicle->vin }}</td>
                        <td>{{ $vehicle->is_clean ? 'YES' : 'NO' }}</td>
                        <td>{{ $vehicle->is_available_for_rent ? 'YES' : 'NO' }}</td>
                        <td>{{ $vehicle->is_door_opened ? 'YES' : 'NO' }}</td>
                        <td>{{ $vehicle->is_in_parking ? 'YES' : 'NO' }}</td>
                        <td>{{ $vehicle->rating }}</td>
                        <td>{{ $vehicle->fuel_in_tank }}</td>
                        <td>
                            @if ($vehicle->location)
                                {{ $vehicle->location->getLatitude() }}, {{ $vehicle->location->getLongitude() }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="flex flex-col gap-2">
                            <button type="submit" wire:click="delete({{ $vehicle->id }})" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete vehicle?')">DELETE &nbsp;
                                <i class="fas fa-trash"></i>
                            </button>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary btn-sm">EDIT&nbsp;
                                <i class="fas fa-edit"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
