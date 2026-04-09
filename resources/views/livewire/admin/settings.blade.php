<div class="card">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Store Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Settings
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="row">
                    <!-- ================= STORE INFORMATION ================= -->
                    <div class="col-md-6 mb-4">
                        <div class="card card-outline card-primary h-100 shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">
                                    <i class="fas fa-store me-2 text-primary"></i> Store Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-600">Store Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email" wire:model="store_email" class="form-control border-start-0 ps-1">
                                        </div>
                                        @error('store_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">Store Phone</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="store_phone" class="form-control border-start-0 ps-1">
                                        </div>
                                        @error('store_phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-600">Store Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 align-items-start pt-2">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                            </span>
                                            <textarea wire:model="store_address" class="form-control border-start-0 ps-1" rows="3"></textarea>
                                        </div>
                                        @error('store_address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-600">GST Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-file-invoice text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="gst_number" class="form-control border-start-0 ps-1">
                                        </div>
                                        @error('gst_number') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-600">Store Logo</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="border rounded p-1 bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px; overflow:hidden;">
                                                @if ($logo && !is_string($logo))
                                                <img src="{{ $logo->temporaryUrl() }}" class="img-fluid rounded" alt="Logo Preview" style="max-height: 100%; object-fit: contain;">
                                                @elseif($existing_logo)
                                                <img src="{{ asset('storage/' . $existing_logo) }}" class="img-fluid rounded" alt="Store Logo" style="max-height: 100%; object-fit: contain;">
                                                @else
                                                <i class="fas fa-image text-muted fs-3"></i>
                                                @endif
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-upload text-muted"></i>
                                                    </span>
                                                    <input type="file" wire:model="logo" class="form-control border-start-0 ps-1" accept="image/*">
                                                </div>
                                                <div wire:loading wire:target="logo" class="text-primary small mt-1">
                                                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Uploading...
                                                </div>
                                                @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= SMTP SETTINGS ================= -->
                    <div class="col-md-6 mb-4">
                        <div class="card card-outline card-info h-100 shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">
                                    <i class="fas fa-paper-plane me-2 text-info"></i> SMTP Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-600">SMTP Host</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-server text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="smtp_host" class="form-control border-start-0 ps-1" placeholder="smtp.mailtrap.io">
                                        </div>
                                        @error('smtp_host') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">SMTP Port</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-plug text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="smtp_port" class="form-control border-start-0 ps-1" placeholder="587">
                                        </div>
                                        @error('smtp_port') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">SMTP Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user-circle text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="smtp_username" class="form-control border-start-0 ps-1">
                                        </div>
                                        @error('smtp_username') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">SMTP Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-key text-muted"></i>
                                            </span>
                                            <input type="password" wire:model="smtp_password" class="form-control border-start-0 ps-1">
                                        </div>
                                        @error('smtp_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-600">Encryption</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <select wire:model="smtp_encryption" class="form-select border-start-0 ps-1">
                                                <option value="">None</option>
                                                <option value="tls">TLS (Recommended)</option>
                                                <option value="ssl">SSL</option>
                                            </select>
                                        </div>
                                        @error('smtp_encryption') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">Mail From Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-at text-muted"></i>
                                            </span>
                                            <input type="email" wire:model="mail_from_address" class="form-control border-start-0 ps-1" placeholder="noreply@trendera.com">
                                        </div>
                                        @error('mail_from_address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-600">Mail From Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-signature text-muted"></i>
                                            </span>
                                            <input type="text" wire:model="mail_from_name" class="form-control border-start-0 ps-1" placeholder="TrendEra Support">
                                        </div>
                                        @error('mail_from_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= INVOICE SETTINGS & TOGGLES ================= -->
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="card card-outline card-success h-100 shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title fw-bold">
                                            <i class="fas fa-file-invoice-dollar me-2 text-success"></i> Invoice Settings
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-600">Invoice Prefix</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-font text-muted"></i>
                                                    </span>
                                                    <input type="text" wire:model="invoice_prefix" class="form-control border-start-0 ps-1" placeholder="e.g. INV-">
                                                </div>
                                                @error('invoice_prefix') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-600">Currency</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-money-bill-wave text-muted"></i>
                                                    </span>
                                                    <select wire:model="currency" class="form-select border-start-0 ps-1">
                                                        <option value="INR">INR (₹)</option>
                                                        <option value="USD">USD ($)</option>
                                                        <option value="EUR">EUR (€)</option>
                                                    </select>
                                                </div>
                                                @error('currency') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-outline card-warning h-100 shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title fw-bold">
                                            <i class="fas fa-toggle-on me-2 text-warning"></i> Features Component
                                        </h3>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-center">

                                        <div class="form-check form-switch fs-5 mb-3 d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" role="switch" id="emailEnabled" wire:model="email_enabled">
                                            <label class="form-check-label pt-1" for="emailEnabled">
                                                <i class="fas fa-envelope-open-text me-2 text-muted"></i> Email Enabled
                                            </label>
                                        </div>

                                        <div class="form-check form-switch fs-5 d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" role="switch" id="notificationEnabled" wire:model="notification_enabled">
                                            <label class="form-check-label pt-1" for="notificationEnabled">
                                                <i class="fas fa-bell me-2 text-muted"></i> Notifications Enabled
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= SAVE BUTTON ================= -->
                <div class="row pb-4">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-5">
                            <span wire:loading.remove wire:target="save"><i class="bi bi-save me-1"></i> Save Settings</span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Saving...
                            </span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!--end::App Content-->
</div>