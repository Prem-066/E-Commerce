<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title">Store Manager</h3>
            @can('create managers')
            <a wire:navigate.hover href="{{ route('admin.manager.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Manager
            </a>
            @endcan
        </div>
    </div>

    <div class="card-body">
        @if(session()->has('success'))
        <div class="py-2 alert alert-success small">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="dataTable" class="table align-middle table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-uppercase small fw-bold">
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Manager & Store Info</th>
                        <th>Salary & Joining</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @can('view managers')
                    @forelse($manager as $key => $m)
                    <tr wire:key="manager-row-{{ $m->id }}">
                        <td class="text-center text-muted fw-bold">
                            {{ $key + 1 }}
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <div class="fw-bold text-dark mb-1">{{ $m->user->name }}</div>
                                <div class="small text-muted">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-envelope text-primary me-2" style="width: 16px;"></i>
                                        <span>{{ $m->user->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone-alt text-primary me-2" style="width: 16px;"></i>
                                        <span>{{ $m->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center fw-bold text-success mb-1">
                                <i class="fa fa-inr me-2" aria-hidden="true"></i>
                                <span>{{ number_format($m->salary, 2) }}</span>
                            </div>
                            <div class="small text-muted d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>Joined: {{ \Carbon\Carbon::parse($m->joining_date)->format('d M, Y') }}</span>
                            </div>
                        </td>

                        {{-- Status Column --}}
                        <td class="text-center">
                            @can('edit managers')
                            <button type="button" wire:click="triggerStatusManagerdes('{{ $m->id }}')"
                                class="border-0 badge {{ $m->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2 shadow-sm">
                                {{ $m->status ? 'Active' : 'Inactive' }}
                            </button>

                            @else
                            <span class="badge {{ $m->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                {{ $m->status ? 'Active' : 'Inactive' }}
                            </span>
                            @endcan
                        </td>

                        {{-- Action Column --}}
                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                @can('edit managers')
                                <a wire:navigate.hover href="{{ route('admin.manager.edit', $m->id) }}"
                                    class="btn btn-sm btn-outline-warning shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete managers')
                                <button wire:click="managerdelete('{{ $m->id }}')" class="btn btn-sm btn-outline-danger shadow-sm" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">
                            <i class="fas fa-user-slash fs-2 d-block mb-2 opacity-50"></i>
                            No Manager Assigned to this Store
                        </td>
                    </tr>
                    @endforelse
                    @else
                    <tr>
                        <td colspan="5" class="py-5 text-center text-danger">
                            <i class="fas fa-exclamation-triangle mb-2 d-block"></i>
                            You do not have permission to view managers.
                        </td>
                    </tr>
                    @endcan
                </tbody>
            </table>
        </div>
    </div>
</div>