<div class="card">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header border-bottom-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h3 class="card-title fw-bold m-0">
                            <i class="fas {{ $managerId ? 'fa-user-edit' : 'fa-user-plus' }} me-2 text-primary"></i>
                            <span class="text-dark">{{ $managerId ? 'Update Staff Member' : 'Register New Staff' }}</span>
                        </h3>
                        <a wire:navigate.hover href="{{ route('admin.manager.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <form wire:submit.prevent="save">
                    <div class="card-body p-lg-4">
                        <div class="mb-4">
                            <h5 class="text-muted fw-bold mb-3 text-uppercase small">
                                <i class="fas fa-id-card me-2"></i>Personal & Contact Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" wire:model.defer="name" class="form-control border-start-0 @error('name') is-invalid @enderror" placeholder="Enter full name">
                                    </div>
                                    @error('name')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" wire:model.defer="email" class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="email@example.com">
                                    </div>
                                    @error('email')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                        <input type="text" wire:model.defer="phone" class="form-control border-start-0 @error('phone') is-invalid @enderror" placeholder="+91 00000 00000">
                                    </div>
                                    @error('phone')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-muted fw-bold mb-3 text-uppercase small">
                                <i class="fas fa-briefcase me-2"></i>Employment Information
                            </h5>
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Role Authority</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-shield text-muted"></i></span>
                                        <select wire:model.live="role" class="form-select border-start-0 @error('role') is-invalid @enderror">
                                            <option value="">Choose Role...</option>
                                            @foreach($roles as $r)
                                            <option value="{{ $r->name }}">{{ ucwords($r->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Monthly Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-wallet text-muted"></i></span>
                                        <input type="number" wire:model.defer="salary" class="form-control border-start-0 @error('salary') is-invalid @enderror" placeholder="0.00">
                                    </div>
                                    @error('salary')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Joining Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-check text-muted"></i></span>
                                        <input type="date" wire:model.defer="joining_date" class="form-control border-start-0 @error('joining_date') is-invalid @enderror">
                                    </div>
                                    @error('joining_date')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-600">Account Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" wire:model.defer="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••">
                                    </div>
                                    @if($managerId) <div class="form-text small">Leave blank to keep current password</div> @endif
                                    @error('password')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 col-md-12 col-lg-8">
                                    <label class="form-label fw-600">Residence Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                        <textarea wire:model.defer="address" rows="1" class="form-control border-start-0 @error('address') is-invalid @enderror" placeholder="Enter full address..."></textarea>
                                    </div>
                                    @error('address')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-lg-4">
                                <h5 class="text-muted fw-bold mb-3 text-uppercase small"><i class="fas fa-toggle-on me-2"></i>Account Status</h5>
                                <div class="p-3 border rounded shadow-xs bg-light">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input cursor-pointer" type="checkbox" wire:model="status" id="statusSwitch" style="width: 2.5rem; height: 1.25rem;">
                                        <label class="form-check-label ms-2 fw-bold" for="statusSwitch">
                                            {{ $status ? 'Active' : 'Deactivated' }}
                                        </label>
                                    </div>
                                    <div class="small text-muted mt-1">Staff member can login only if active.</div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <h5 class="text-muted fw-bold mb-4 text-uppercase small">
                                    <i class="fas fa-shield-alt me-2 text-warning"></i> Access Control & Extra Permissions
                                </h5>

                                <div class="permission-wrapper border rounded bg-white shadow-sm p-3">
                                    @foreach($availablePermissions as $group => $permissions)
                                    <div class="permission-row mb-4 last-child-mb-0">
                                        <div class="d-flex align-items-center mb-2 border-bottom pb-1">
                                            <h6 class="text-primary fw-bold mb-0 text-uppercase small" style="min-width: 150px;">
                                                <i class="bi bi-folder2-open me-2"></i> {{ $group }}
                                            </h6>
                                        </div>

                                        <div class="row g-2">
                                            @foreach($permissions as $perm)
                                            <div class="col-6 col-md-4 col-xl-3">
                                                <div class="p-2 border rounded shadow-xs d-flex align-items-center bg-light-hover transition-all">
                                                    <div class="form-check mb-0 w-100">
                                                        <input type="checkbox"
                                                            class="form-check-input cursor-pointer"
                                                            wire:model="selectedPermissions"
                                                            value="{{ $perm['name'] }}"
                                                            id="perm-{{ \Illuminate\Support\Str::slug($perm['name']) }}">

                                                        <label class="form-check-label ms-1 small fw-medium text-dark cursor-pointer d-block"
                                                            for="perm-{{ \Illuminate\Support\Str::slug($perm['name']) }}">
                                                            @php
                                                            $label = ucwords(str_replace($group, '', $perm['name']));
                                                            @endphp
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

                            <style>
                                .bg-light-hover:hover {
                                    background-color: #f8faff !important;
                                    border-color: #0d6efd !important;
                                    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
                                }

                                .extra-small {
                                    font-size: 10px;
                                }

                                .transition-all {
                                    transition: all 0.2s ease;
                                }

                                .cursor-pointer {
                                    cursor: pointer;
                                }

                                .last-child-mb-0:last-child {
                                    margin-bottom: 0 !important;
                                }

                                .permission-wrapper {
                                    max-height: 500px;
                                    /* જરૂર મુજબ વધ-ઘટ કરી શકાય */
                                    overflow-y: auto;
                                }
                            </style>
                        </div>
                    </div>

                    <div class="card-footer bg-light p-4 border-top">
                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                            <button type="button"
                                class="btn btn-light px-4 border shadow-sm "
                                onclick="history.back()">
                                Cancel
                            </button>

                            <button type="submit"
                                class="btn btn-primary px-5 shadow "
                                wire:loading.attr="disabled"
                                wire:target="save">

                                <span wire:loading.remove wire:target="save">
                                    <i class="fas fa-save me-1"></i>
                                    {{ $managerId ? 'Save Changes' : 'Create Staff' }}
                                </span>

                                <span wire:loading wire:target="save">
                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .fw-600 {
            font-weight: 600;
        }

        .shadow-xs {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        }

        .bg-light-hover:hover {
            background-color: #f8f9fa;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .input-group-text {
            min-width: 45px;
            justify-content: center;
        }

        @media (max-width: 576px) {
            .card-header .btn {
                width: 100%;
            }

            .card-footer .btn {
                flex: 1;
            }
        }
    </style>
</div>