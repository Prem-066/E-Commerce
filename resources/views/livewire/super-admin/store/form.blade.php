<div class="mt-2 card">
    <div class="py-3 card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="mb-0 card-title fw-bold">
                <i class="fas {{ $storeId ? 'fa-edit' : 'fa-plus-circle' }} me-2 text-primary"></i>
                <span class="text-primary">{{ $storeId ? 'Edit Store Details' : 'Create New Store' }}</span>
            </h3>

            <a wire:navigate.hover href="{{ route('superadmin.stores.index') }}"
                class="px-3 shadow-sm btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="p-4 card-body">
            <div class="row">
                <!-- Store Name -->
                <div class="mb-3 col-md-12">
                    <label class="form-label fw-semibold">Store Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-store text-muted"></i></span>
                        <input type="text" wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Main Street Branch">
                    </div>
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <!-- Email Address -->
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="store@example.com">
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-semibold">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                        <input type="text" wire:model.defer="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="+1 234 567 890">
                    </div>
                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <!-- Manager Selection -->
                <div class="mb-3 col-md-12">
                    <label class="form-label fw-semibold">Assigned Admin</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user-tie text-muted"></i></span>
                        <select wire:model.defer="admin_id" class="form-select @error('admin_id') is-invalid @enderror">
                            <option value="">Select a Admin </option>
                            @foreach($admin as $adm)
                            <option value="{{ $adm->id }}">{{ $adm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('admin_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <!-- Address -->
                <div class="mb-3 col-md-12">
                    <label class="form-label fw-semibold">Physical Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-muted"></i></span>
                        <textarea wire:model.defer="address" rows="2"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Full address of the store..."></textarea>
                    </div>
                    @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Optional: Store Features/Settings Section (Matches your Permissions style) -->
            <hr class="my-4 opacity-50">
            <div class="form-group">
                <label class="mb-3 form-label fw-bold d-block">
                    <i class="fas fa-toggle-on me-2 text-warning"></i> Store Status
                </label>
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div
                            class="p-2 transition-all border rounded shadow-sm form-check d-flex align-items-center h-100 bg-light-hover">
                            <input type="checkbox" class="form-check-input ms-0 me-2" wire:model="status"
                                id="store-status">
                            <label class="mb-0 form-check-label text-dark small fw-medium" for="store-status">
                                {{ $status ? 'Active' : 'Inactive' }}
                            </label>
                        </div>
                        @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="p-4 bg-light card-footer border-top">
            <div class="gap-2 d-flex justify-content-end">
                <button type="button" class="px-4 border shadow-sm btn btn-light">
                    Cancel
                </button>

                <button type="submit" class="px-4 shadow-sm btn btn-primary" wire:loading.attr="disabled"
                    wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save me-1"></i> {{ $storeId ? 'Update Store' : 'Create Store' }}
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin me-1"></i> Saving...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>