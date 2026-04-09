<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title">User Management</h3>

            @can('create users')
            <a wire:navigate.hover href="{{ route('superadmin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add User
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body">


        <div class="table-responsive" wire:ignore>
            <table id="dataTable" class="table align-middle table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th class="d-none d-md-table-cell">Email</th> 
                        <th>Role</th>
                        <th class="text-center">Points</th>
                        <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @can('view users')
                    @forelse($users as $key => $user)
                    <tr>
                        <td class="text-center text-muted">
                            {{ $key + 1 }}
                        </td>
                        <td>
                            <div class="fw-bold">{{ $user->name }}</div>
                            <small class="text-muted d-md-none">{{ $user->email }}</small>
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $user->email }}
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $user->roles->first()?->name ?? 'No Role' }}
                            </span>
                            @can('manage users')
                            <small class="d-block text-primary">Manage Access</small>
                            @endcan
                        </td>
                        <td class="text-center">
                            @if($user->customer)
                            <span class="fw-bold text-warning">{{ $user->customer->loyalty_points ?? 0 }}</span>
                            <small class="text-muted d-block small" style="font-size: 9px;">Points</small>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
                        </td>


                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                @can('edit users')
                                <a wire:navigate.hover href="{{ route('superadmin.users.edit', $user->id) }}"
                                    class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan

                                @can('delete users')
                                <button type="button" wire:click="triggerDelete({{ $user->id }})"
                                    class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                @endcan

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-muted">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                    @endcan
                </tbody>
            </table>
        </div>
    </div>
</div>