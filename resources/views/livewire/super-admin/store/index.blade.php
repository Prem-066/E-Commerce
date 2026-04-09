<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title">Stores Management</h3>
            @can('create stores')
            <a wire:navigate.hover href="{{ route('superadmin.stores.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Store
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
                        <th>Store Name</th>
                        <th class="d-none d-md-table-cell">Contact Info</th>
                        <th>Admin</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @can('view stores')
                    @forelse($stores as $key => $store)
                    <tr>
                        <td class="text-center text-muted">
                            {{ $key + 1 }}
                        </td>
                        <td>
                            <div class="fw-bold">{{ $store->name }}</div>
                            <div class="small text-muted d-md-none">
                                <div><i class="bi bi-envelope me-1"></i> {{ $store->email }}</div>
                                <div><i class="bi bi-telephone me-1"></i> {{ $store->phone }}</div>
                            </div>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="small">{{ $store->email }}</div>
                            <div class="small text-muted">{{ $store->phone }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $store->admin->name ?? 'No Admin' }}
                            </span>
                        </td>
                        <td>
                            @can('edit stores')
                            <button type="button" wire:click="triggerStatusStore('{{ $store->id }}')"
                                class="border-0 badge {{ $store->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                {{ $store->status ? 'Active' : 'Inactive' }}
                            </button>
                            @else
                            <span class="badge {{ $store->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                {{ $store->status ? 'Active' : 'Inactive' }}
                            </span>
                            @endcan
                        </td>
                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                @can('edit stores')
                                <a wire:navigate.hover href="{{ route('superadmin.stores.edit', $store->id) }}"
                                    class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan

                                @can('delete stores')
                                <button type="button" wire:click="triggerDelete({{ $store->id }})"
                                    class="btn btn-outline-danger btn-sm" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-muted">
                            No stores found.
                        </td>
                    </tr>
                    @endforelse
                    @endcan
                </tbody>
            </table>
        </div>
    </div>
</div>