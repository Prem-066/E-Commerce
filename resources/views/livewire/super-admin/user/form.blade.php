<div class="mt-2 card">
    <div class="py-3 card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title fw-bold">
                <i class="fas {{ $userId ? 'fa-user-edit' : 'fa-user-plus' }} me-2 text-primary"></i>
                <span class="text-primary">{{ $userId ? 'Edit User Profile' : 'Create New User' }}</span>
            </h3>

            <a wire:navigate.hover href="{{ route('superadmin.users.index') }}"
                class="px-3 shadow-sm btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Users
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="p-4 card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="John Doe">
                    </div>
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="john@example.com">
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">
                        Password
                        @if($userId) <span class="badge bg-soft-warning text-dark fw-normal ms-1"
                            style="font-size: 0.7rem;">Optional</span> @endif
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" wire:model.defer="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                    </div>
                    @if($userId)
                    <small class="mt-1 text-muted d-block">Leave blank to keep current password</small>
                    @endif
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">User Role</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-shield-alt text-muted"></i></span>
                        <select wire:model.live="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">Select a Role</option>
                            @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucwords($r->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('role')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4 opacity-50">

            <div class="form-group">
                <label class="mb-4 form-label fw-bold d-block border-bottom pb-2">
                    <i class="fas fa-shield-alt me-2 text-warning"></i> User Permissions
                </label>

                @foreach($availablePermissions as $groupName => $permissions)
                <div class="mb-4">
                    <h6 class="text-primary fw-bold text-uppercase small mb-3">
                        <i class="bi bi-folder2-open me-1"></i> {{ $groupName }} Management
                    </h6>

                    <div class="row g-2">
                        @foreach($permissions as $perm)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="permission-card border rounded p-2 d-flex align-items-center bg-white shadow-sm">
                                <div class="form-check mb-0">
                                    <input type="checkbox"
                                        class="form-check-input cursor-pointer"
                                        wire:model="selectedPermissions"
                                        value="{{ $perm['name'] }}"
                                        id="perm-{{ $perm['id'] }}">
                                    <label class="form-check-label small fw-medium text-dark cursor-pointer ms-1"
                                        for="perm-{{ $perm['id'] }}">
                                        {{ ucwords(str_replace($groupName, '', $perm['name'])) }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
        </div>

        <style>
            .permission-card {
                transition: all 0.2s ease;
            }

            .permission-card:hover {
                border-color: #0d6efd !important;
                background-color: #f8f9fa !important;
            }

            .cursor-pointer {
                cursor: pointer;
            }
        </style>
</div>

<div class="p-4 bg-light card-footer border-top">
    <div class="gap-2 d-flex justify-content-end">
        <a wire:navigate href="{{ route('superadmin.users.index') }}"
            class="px-4 border shadow-sm btn btn-light">
            Cancel
        </a>

        <button type="submit" class="px-4 shadow-sm btn btn-primary" wire:loading.attr="disabled"
            wire:target="save">
            <span wire:loading.remove wire:target="save">
                <i class="fas fa-save me-1"></i> {{ $userId ? 'Save Changes' : 'Create User' }}
            </span>
            <span wire:loading wire:target="save">
                <i class="fas fa-spinner fa-spin me-1"></i> Saving...
            </span>
        </button>
    </div>
</div>
</form>

<style>
    .bg-light-hover:hover {
        background-color: #f8f9fa !important;
        border-color: #0d6efd !important;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .bg-soft-warning {
        background-color: #fff3cd;
    }
</style>
</div>