<div class="container-fluid py-4">
    <form wire:submit.prevent="saveSettings">
        <div class="row">

            <div class="col-md-6">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-id-card me-2"></i> Brand Info</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-600">Website Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-globe text-muted"></i></span>
                                <input type="text" wire:model="website_name" class="form-control border-start-0 ps-1 @error('website_name') is-invalid @enderror">
                            </div>
                            @error('website_name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Logo</label>
                                <input type="file" wire:model="logo" id="upload_logo" class="form-control @error('logo') is-invalid @enderror">
                                @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror

                                <div class="mt-3 p-2 border rounded bg-light text-center" style="min-height: 100px;">
                                    <small class="text-muted d-block mb-1">Logo Preview</small>
                                    @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail shadow-sm" style="max-height: 80px;">
                                    @elseif ($old_logo)
                                    <img src="{{ asset('storage/' . $old_logo) }}" class="img-thumbnail shadow-sm" style="max-height: 80px;">
                                    @else
                                    <div class="py-3 text-muted"><i class="fas fa-image fa-2x"></i></div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Favicon</label>
                                <input type="file" wire:model="favicon" id="upload_favicon" class="form-control @error('favicon') is-invalid @enderror">
                                @error('favicon') <span class="text-danger small">{{ $message }}</span> @enderror

                                <div class="mt-3 p-2 border rounded bg-light text-center" style="min-height: 100px;">
                                    <small class="text-muted d-block mb-1">Favicon Preview</small>
                                    @if ($favicon)
                                    <img src="{{ $favicon->temporaryUrl() }}" class="img-thumbnail shadow-sm" style="max-height: 50px;">
                                    @elseif ($old_favicon)
                                    <img src="{{ asset('storage/' . $old_favicon) }}" class="img-thumbnail shadow-sm" style="max-height: 50px;">
                                    @else
                                    <div class="py-3 text-muted"><i class="fas fa-file-image fa-2x"></i></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card card-success card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-headset me-2"></i> Contact Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" wire:model="contact_email" class="form-control border-start-0 ps-1 @error('contact_email') is-invalid @enderror">
                                </div>
                                @error('contact_email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" wire:model="contact_phone" class="form-control border-start-0 ps-1 @error('contact_phone') is-invalid @enderror">
                                </div>
                                @error('contact_phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marked-alt text-muted"></i></span>
                                <textarea wire:model="address" class="form-control border-start-0 ps-1 @error('address') is-invalid @enderror" rows="2"></textarea>
                            </div>
                            @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-warning card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marker-alt me-2"></i> Localization</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Time Zone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-clock text-muted"></i></span>
                                    <input type="text" wire:model="time_zone" class="form-control border-start-0 ps-1 @error('time_zone') is-invalid @enderror">
                                </div>
                                @error('time_zone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Default Language</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-language text-muted"></i></span>
                                    <input type="text" wire:model="default_language" class="form-control border-start-0 ps-1 @error('default_language') is-invalid @enderror">
                                </div>
                                @error('default_language') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Currency Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-coins text-muted"></i></span>
                                    <input type="text" wire:model="currency_code" class="form-control border-start-0 ps-1 @error('currency_code') is-invalid @enderror" placeholder="INR">
                                </div>
                                @error('currency_code') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Currency Symbol</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-yen-sign text-muted"></i></span>
                                    <input type="text" wire:model="currency_symbol" class="form-control border-start-0 ps-1 @error('currency_symbol') is-invalid @enderror" placeholder="₹">
                                </div>
                                @error('currency_symbol') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-danger card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-wallet me-2"></i> Business Rules</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" wire:model="enable_cod">
                                    <label class="form-check-label">Enable COD</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Default GST (%)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-percent text-muted"></i></span>
                                    <input type="number" step="0.01" wire:model="default_gst_percentage" class="form-control border-start-0 ps-1 @error('default_gst_percentage') is-invalid @enderror">
                                </div>
                                @error('default_gst_percentage') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" wire:model="enable_free_shipping">
                                    <label class="form-check-label">Free Shipping</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-600">Free Shipping Threshold</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-truck text-muted"></i></span>
                                    <input type="number" wire:model="free_shipping_threshold" class="form-control border-start-0 ps-1 @error('free_shipping_threshold') is-invalid @enderror">
                                </div>
                                @error('free_shipping_threshold') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-dark card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tools me-2"></i> Site Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                            <div>
                                <h6 class="mb-0 fw-bold">Maintenance Mode</h6>
                                <small>When enabled, the site will be in maintenance mode</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input scale-150" type="checkbox" wire:model="maintenance_mode" id="maintenanceSwitch">
                                <label class="form-check-label ms-2 fw-bold {{ $maintenance_mode ? 'text-danger' : 'text-success' }}" for="maintenanceSwitch">
                                    {{ $maintenance_mode ? 'ON' : 'OFF' }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-paper-plane me-2"></i> SMTP Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-600">Host</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-server text-muted"></i></span>
                                    <input type="text" wire:model="mail_host" class="form-control border-start-0 ps-1 @error('mail_host') is-invalid @enderror">
                                </div>
                                @error('mail_host') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-600">Port</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-plug text-muted"></i></span>
                                    <input type="text" wire:model="mail_port" class="form-control border-start-0 ps-1 @error('mail_port') is-invalid @enderror">
                                </div>
                                @error('mail_port') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-600">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-shield text-muted"></i></span>
                                    <input type="text" wire:model="mail_username" class="form-control border-start-0 ps-1 @error('mail_username') is-invalid @enderror">
                                </div>
                                @error('mail_username') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-600">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                    <input type="password" wire:model="mail_password" class="form-control border-start-0 ps-1 @error('mail_password') is-invalid @enderror">
                                </div>
                                @error('mail_password') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-600">Encryption</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="text" wire:model="mail_encryption" class="form-control border-start-0 ps-1 @error('mail_encryption') is-invalid @enderror" placeholder="tls/ssl">
                                </div>
                                @error('mail_encryption') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-600">From Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-at text-muted"></i></span>
                                    <input type="email" wire:model="mail_from_address" class="form-control border-start-0 ps-1 @error('mail_from_address') is-invalid @enderror">
                                </div>
                                @error('mail_from_address') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-600">From Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-signature text-muted"></i></span>
                                    <input type="text" wire:model="mail_from_name" class="form-control border-start-0 ps-1 @error('mail_from_name') is-invalid @enderror">
                                </div>
                                @error('mail_from_name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-secondary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-contract me-2"></i> Policies & Legal</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-600">Terms & Conditions</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-scroll text-muted"></i></span>
                                    <textarea wire:model="terms_and_conditions" class="form-control border-start-0 ps-1 @error('terms_and_conditions') is-invalid @enderror" rows="4"></textarea>
                                </div>
                                @error('terms_and_conditions') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-600">Privacy Policy</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-secret text-muted"></i></span>
                                    <textarea wire:model="privacy_policy" class="form-control border-start-0 ps-1 @error('privacy_policy') is-invalid @enderror" rows="4"></textarea>
                                </div>
                                @error('privacy_policy') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-600">Return Policy</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-undo text-muted"></i></span>
                                    <textarea wire:model="return_policy" class="form-control border-start-0 ps-1 @error('return_policy') is-invalid @enderror" rows="4"></textarea>
                                </div>
                                @error('return_policy') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card bg-light mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-600">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fab fa-facebook text-primary"></i></span>
                                    <input type="text" wire:model="facebook_link" class="form-control border-start-0 ps-1 @error('facebook_link') is-invalid @enderror">
                                </div>
                                @error('facebook_link') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-600">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fab fa-instagram text-danger"></i></span>
                                    <input type="text" wire:model="instagram_link" class="form-control border-start-0 ps-1 @error('instagram_link') is-invalid @enderror">
                                </div>
                                @error('instagram_link') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-600">Twitter</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fab fa-twitter text-info"></i></span>
                                    <input type="text" wire:model="twitter_link" class="form-control border-start-0 ps-1 @error('twitter_link') is-invalid @enderror">
                                </div>
                                @error('twitter_link') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3 text-center border-start">
                                <label class="form-label d-block fw-bold">Security (2FA)</label>
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" wire:model="enable_2fa">
                                    <span class="ms-1">Enable</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 text-end mb-5 mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow ">
                    <span wire:loading.remove wire:target="saveSettings">
                        <i class="fas fa-save me-2"></i> Update Global Settings
                    </span>
                    <span wire:loading wire:target="saveSettings">
                        <i class="fas fa-spinner fa-spin me-2"></i> Processing...
                    </span>
                </button>
            </div>

        </div>
    </form>
</div>