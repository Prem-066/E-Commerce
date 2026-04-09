<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title">Store Employee</h3>

            <a wire:navigate.hover href="{{ route('store.manager.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Employee
            </a>

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
                        <th>Employee & Store Info</th>
                        <th>Salary & Joining</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $key => $e)
                    <tr>
                        <td class="text-center text-muted fw-bold">
                            {{ $key + 1 }}
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <div class="fw-bold text-dark mb-1">{{ $e->user->name }}</div>
                                <div class="small text-muted">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-envelope text-primary me-2" style="width: 16px;"></i>
                                        <span>{{ $e->user->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone-alt text-primary me-2" style="width: 16px;"></i>
                                        <span>{{ $e->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center fw-bold text-success mb-1">
                                <i class="fa fa-inr me-2" aria-hidden="true"></i>
                                <span>{{ number_format($e->salary, 2) }}</span>
                            </div>
                            <div class="small text-muted d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>Joined: {{ \Carbon\Carbon::parse($e->joining_date)->format('d M, Y') }}</span>
                            </div>
                        </td>

                        <td class="text-center">
                            <button type="button" wire:click="triggerStatusManager('{{ $e->id }}')"
                                class="border-0 badge {{ $e->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                {{ $e->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                <a wire:navigate.hover href="{{ route('store.manager.edit', $e->id) }}"
                                    class="btn btn-sm btn-outline-warning shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="triggerDelete('{{ $e->id }}')" class="btn btn-sm btn-outline-danger shadow-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>