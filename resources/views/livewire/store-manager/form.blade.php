<div class="card border-0 shadow-sm">
    <div class="card card-outline card-primary shadow-none border-top-3">
        <div class="card-header border-bottom-0 pt-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title fw-bold m-0">
                    <i class="fas {{ $managerId ? 'fa-user-edit' : 'fa-user-plus' }} me-2 text-primary"></i>
                    <span class="text-dark">{{ $managerId ? 'Update Staff Member' : 'Register New Staff' }}</span>
                </h3>
                <a wire:navigate.hover href="{{ route('store.manager.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="card-body p-lg-4">

                <div class="mb-5">
                    <h5 class="section-title">
                        <i class="fas fa-id-card me-2 text-primary"></i>Personal & Contact Details
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name">
                            </div>
                            @error('name')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                            </div>
                            @error('email')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone text-muted"></i></span>
                                <input type="text" wire:model.defer="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+91 00000 00000">
                            </div>
                            @error('phone')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="section-title">
                        <i class="fas fa-briefcase me-2 text-primary"></i>Employment Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Designation</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tag text-muted"></i></span>
                                <input type="text" wire:model.defer="designations" class="form-control @error('designations') is-invalid @enderror" placeholder="e.g. Sales Executive">
                            </div>
                            @error('designations')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Role Authority</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-shield text-muted"></i></span>
                                <select wire:model.live="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">Choose Role...</option>
                                    @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ ucwords($r->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Employment Type</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-clock text-muted"></i></span>
                                <select wire:model.defer="employment_type" class="form-select @error('employment_type') is-invalid @enderror">
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                </select>
                            </div>
                            @error('employment_type')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Monthly Salary</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-wallet text-muted"></i></span>
                                <input type="number" wire:model.defer="salary" class="form-control @error('salary') is-invalid @enderror" placeholder="0.00">
                            </div>
                            @error('salary')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Joining Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-check text-muted"></i></span>
                                <input type="date" wire:model.defer="joining_date" class="form-control @error('joining_date') is-invalid @enderror">
                            </div>
                            @error('joining_date')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label fw-600">Account Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" wire:model.defer="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                            </div>
                            @if($managerId) <div class="form-text extra-small text-info">Leave blank to keep current</div> @endif
                            @error('password')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-600">Residence Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                <textarea wire:model.defer="address" rows="2" class="form-control @error('address') is-invalid @enderror" placeholder="Enter full address..."></textarea>
                            </div>
                            @error('address')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-xl-3">
                        <h5 class="section-title small"><i class="fas fa-toggle-on me-2"></i>Account Status</h5>
                        <div class="status-card p-3 border rounded-3 bg-light transition-all">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" wire:model="status" id="statusSwitch">
                                <label class="form-check-label ms-2 fw-bold" for="statusSwitch">
                                    {{ $status ? 'Active' : 'Deactivated' }}
                                </label>
                            </div>
                            <div class="extra-small text-muted mt-2">Staff can only login when active.</div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-9">
                        <h5 class="section-title small">
                            <i class="fas fa-shield-alt me-2 text-warning"></i> Access Control & Extra Permissions
                        </h5>

                        <div class="permission-wrapper border rounded-3 bg-white p-3 shadow-xs">
                            @foreach($availablePermissions as $group => $permissions)
                            <div class="mb-4 last-child-mb-0">
                                <div class="d-flex align-items-center mb-3 border-bottom pb-1">
                                    <h6 class="text-primary fw-bold mb-0 text-uppercase extra-small tracking-wider">
                                        {{ $group }}
                                    </h6>
                                </div>

                                <div class="row g-2">
                                    @foreach($permissions as $perm)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="permission-item p-2 border rounded transition-all">
                                            <div class="form-check mb-0">
                                                <input type="checkbox" class="form-check-input cursor-pointer"
                                                    wire:model="selectedPermissions" value="{{ $perm['name'] }}"
                                                    id="perm-{{ \Illuminate\Support\Str::slug($perm['name']) }}">
                                                <label class="form-check-label ms-1 small fw-medium text-dark cursor-pointer d-block text-truncate"
                                                    for="perm-{{ \Illuminate\Support\Str::slug($perm['name']) }}">
                                                    @php $label = ucwords(str_replace($group, '', $perm['name'])); @endphp
                                                    {{ $label ?: ucwords($perm['name']) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light p-4 border-top d-flex justify-content-end gap-3">
                <button type="button" class="btn btn-link text-secondary text-decoration-none px-4" onclick="history.back()">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary px-5 shadow-sm rounded-pill" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save me-2"></i>{{ $managerId ? 'Save Changes' : 'Create Staff Member' }}
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin me-2"></i>Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <style>
        .fw-600 {
            font-weight: 600;
            color: #444;
            font-size: 0.9rem;
        }

        .section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .extra-small {
            font-size: 0.75rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            min-width: 42px;
            justify-content: center;
        }

        .form-control,
        .form-select {
            border-left: none;
            padding-left: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #dee2e6;
            box-shadow: none;
            background-color: #fff;
        }

        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd !important;
        }

        .input-group:focus-within .form-control {
            border-color: #0d6efd;
        }

        /* Permissions & Status */
        .permission-wrapper {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .permission-item:hover {
            background-color: #f0f7ff;
            border-color: #0d6efd !important;
        }

        .status-card:hover {
            background-color: #fff !important;
            border-color: #0d6efd !important;
        }

        /* Switches */
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
            cursor: pointer;
        }

        /* Utilities */
        .cursor-pointer {
            cursor: pointer;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .shadow-xs {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
        }

        .last-child-mb-0:last-child {
            margin-bottom: 0 !important;
        }

        @media (max-width: 576px) {
            .card-footer {
                flex-direction: column-reverse;
            }

            .card-footer .btn {
                width: 100%;
            }
        }
    </style>
</div>