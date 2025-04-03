<div>
    <!--
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
            <div class="card-tools">
                <select wire:model.live="perPage" class="form-control form-control-sm">
                    <option value="20">20 per page</option>
                    <option value="40">40 per page</option>
                    <option value="60">60 per page</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="driver">Driver</label>
                        <input type="text"
                               id="driver"
                               wire:model.defer="filters.driver"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="vehicle">Vehicle</label>
                        <input type="text"
                               id="vehicle"
                               wire:model.defer="filters.vehicle"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="isActive">Activity</label>
                        <select id="isActive"
                                wire:model.defer="filters.isActive"
                                class="form-control">
                            <option value="">All</option>
                            <option value="true">Active</option>
                            <option value="false">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status"
                                wire:model.defer="filters.status"
                                class="form-control">
                            <option value="">All</option>
                            <option value="reserve">Reserve</option>
                            <option value="prepare">Prepare</option>,
                            <option value="driving">Driving</option>,
                            <option value="parking">Parking</option>,
                            <option value="finished">Finished</option>,
                            <option value="failed">Failed</option>,
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="createdAtFrom">Date created from</label>
                        <input type="date"
                               id="createdAtFrom"
                               wire:model.defer="filters.createdAtFrom"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="createdAtTo">Date created before</label>
                        <input type="date"
                               id="createdAtTo"
                               wire:model.defer="filters.createdAtTo"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="finishedAtFrom">Completion date from</label>
                        <input type="date"
                               id="finishedAtFrom"
                               wire:model.defer="filters.finishedAtFrom"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="finishedAtTo">Completion date to</label>
                        <input type="date"
                               id="finishedAtTo"
                               wire:model.defer="filters.finishedAtTo"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="costTotalFrom">Total cost from</label>
                        <input type="number"
                               step="0.01"
                               id="costTotalFrom"
                               wire:model.defer="filters.costTotalFrom"
                               class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label for="costTotalTo">Total cost up to</label>
                        <input type="number"
                               step="0.01"
                               id="costTotalTo"
                               wire:model.defer="filters.costTotalTo"
                               class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <button wire:click="applyFilters"
                            class="btn btn-primary"
                            wire:loading.attr="disabled">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <button wire:click="resetFilters"
                            class="btn btn-default"
                            wire:loading.attr="disabled">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>


-->
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Activity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>
                            <span class="badge badge-{{ $driver->is_active ? 'success' : 'danger' }}">
                                {{ $driver->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            <i class="fas fa-database mr-1"></i> No data found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $drivers->links() }}
        </div>
    </div>
</div>
