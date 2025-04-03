<div>
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
