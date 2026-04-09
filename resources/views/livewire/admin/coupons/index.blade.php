<div class="card p-4">
    <div class="d-flex justify-content-between align-items-end mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Coupons Management</h4>
            <div class="d-flex align-items-center gap-2 mt-1">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 small">{{ $coupons->total() }} Active Offers</span>
                <span class="text-muted extra-small">• Manage your store discounts</span>
            </div>
        </div>
        <button wire:click="openModal" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 shadow-sm rounded-3 fw-semibold">
            <i class="fas fa-plus-circle"></i> Create New Coupon
        </button>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <div class="input-group search-box" style="max-width: 350px;">
            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted small"></i></span>
            <input type="text" wire:model.live="search" class="form-control border-start-0 ps-0 shadow-none border" placeholder="Search coupons...">
        </div>
    </div>

    <div class="row g-4 mb-4">
        @forelse($coupons as $coupon)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 coupon-card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="ribbon-wrapper">
                    @php
                    if ($coupon->valid_until->isPast() || !$coupon->is_active) {
                    $ribbonColor = '#94a3b8'; // Muted Gray
                    } else {
                    $ribbonColor = $coupon->discount_type == 'percentage' ? '#4f46e5' : '#f59e0b';
                    }
                    @endphp
                    <div class="ribbon" style="background-color: {{ $ribbonColor }};">
                        {{ $coupon->discount_type == 'percentage' ? $coupon->discount_value.'%' : '₹'.number_format($coupon->discount_value) }} OFF
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="coupon-code-container mb-3 text-center py-2 px-3 rounded-3">
                        <span class="text-uppercase fw-bold letter-spacing-1 text-primary fs-5">{{ $coupon->code }}</span>
                        <p class="text-muted extra-small mb-0 mt-1">{{ Str::limit($coupon->description, 45) }}</p>
                    </div>

                    <div class="info-grid mt-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-light-subtle">
                                    <span class="text-muted extra-small d-block text-uppercase">Min Order</span>
                                    <span class="fw-bold small text-dark">₹{{ number_format($coupon->min_order_amount) }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-light-subtle">
                                    <span class="text-muted extra-small d-block text-uppercase">Max Save</span>
                                    <span class="fw-bold small text-dark">₹{{ number_format($coupon->max_discount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-3 text-muted">
                        <i class="far fa-clock small"></i>
                        <span class="extra-small">Ends on: <strong>{{ $coupon->valid_until->format('M d, Y') }}</strong></span>
                    </div>

                    <hr class="my-3 dashed-hr">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="usage-stats">
                            <span class="text-muted extra-small d-block">Usage Limit</span>
                            <div class="progress mt-1" style="height: 4px; width: 60px;">
                                <div class="progress-bar bg-success" style="width: 45%"></div>
                            </div>
                            <span class="extra-small fw-medium">0 / {{ $coupon->usage_limit ?? '∞' }}</span>
                        </div>

                        <div class="action-buttons d-flex gap-1">
                            <button wire:click="editCoupon({{ $coupon->id }})" class="btn btn-action-icon btn-edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $coupon->id }})" class="btn btn-action-icon btn-delete" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                            
                            <div class="form-check form-switch ms-1">
                                <input class="form-check-input custom-switch" type="checkbox"
                                    wire:click="toggleStatus({{ $coupon->id }})"
                                    {{ $coupon->is_active ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="fas fa-ticket-alt fa-3x text-light mb-3"></i>
                <h5 class="text-secondary fw-bold">No Coupons Found</h5>
                <p class="text-muted small">Create your first coupon to get started!</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $coupons->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">{{ $couponId ? 'Edit Coupon' : 'Create New Coupon' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit="saveCoupon">
                    <div class="modal-body py-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted mb-1">Coupon Code *</label>
                                <input type="text" wire:model="code" class="form-control shadow-none rounded-3" placeholder="E.G., SAVE20">
                                @error('code') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted mb-1">Description *</label>
                                <textarea wire:model="description" class="form-control shadow-none rounded-3" rows="2" placeholder="e.g., 20% off on first order"></textarea>
                                @error('description') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Discount Type</label>
                                <select wire:model="discount_type" class="form-select shadow-none rounded-3">
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="fixed">Fixed Amount (₹)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Discount Value *</label>
                                <input type="number" wire:model="discount_value" class="form-control shadow-none rounded-3" placeholder="Value">
                                @error('discount_value') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Min Order Amount</label>
                                <input type="number" wire:model="min_order_amount" class="form-control shadow-none rounded-3" placeholder="₹">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Max Discount</label>
                                <input type="number" wire:model="max_discount" class="form-control shadow-none rounded-3" placeholder="₹">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Valid From *</label>
                                <input type="date" wire:model="valid_from" class="form-control shadow-none rounded-3">
                                @error('valid_from') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Valid Until *</label>
                                <input type="date" wire:model="valid_until" class="form-control shadow-none rounded-3">
                                @error('valid_until') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted mb-1">Usage Limit</label>
                                <input type="number" wire:model="usage_limit" class="form-control shadow-none rounded-3" placeholder="Limit">
                            </div>
                            <div class="col-md-6 d-flex align-items-center mt-auto">
                                <div class="form-check form-switch mt-3 pt-1">
                                    <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
                                    <label class="form-check-label fw-bold small text-muted ps-2" for="isActiveSwitch">Is Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4">
                        <button type="button" class="btn btn-light px-4 rounded-3 fw-medium"
                            data-bs-dismiss="modal"
                            wire:click="$dispatch('hideModal')">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary px-4 rounded-3 shadow-sm fw-medium" wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ $couponId ? 'Update Coupon' : 'Create Coupon' }}</span>
                            <span wire:loading><i class="fas fa-circle-notch fa-spin me-2"></i>Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Typography & General */
        .extra-small {
            font-size: 0.72rem;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        /* Coupon Card Styling */
        /* Premium Glassmorphism Effect */
        .coupon-card {
            background: linear-gradient(135deg, #8fc3e5ff 0%, #e3eaecff 100%);
            backdrop-filter: blur(8px);
            /* હળવો બેકગ્રાઉન્ડ બ્લર */
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.4);
            /* આછી બોર્ડર */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            /* આછો શેડો */
        }

        .coupon-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }

        /* કૂપન કોડ કન્ટેનરને વધુ આકર્ષક બનાવ્યું */
        .coupon-code-container {
            background: #f1f5f9;
            /* લાઇટ ગ્રેડ ગ્રે */
            border: 2px dashed #e2e8f0;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            /* આછો ઇનસેટ શેડો */
        }

        .coupon-code-container::before,
        .coupon-code-container::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 12px;
            height: 12px;
            background: #fff;
            border-radius: 50%;
            transform: translateY(-50%);
            border: 1px solid #e2e8f0;
        }

        .coupon-code-container::before {
            left: -7px;
        }

        .coupon-code-container::after {
            right: -7px;
        }

        /* Buttons & Switches */
        .btn-action-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.2s;
            background: #f1f5f9;
            border: none;
        }

        .btn-edit:hover {
            background: #e0e7ff;
            color: #4338ca;
        }

        .btn-delete:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .custom-switch {
            width: 2.2em !important;
            height: 1.2em !important;
            cursor: pointer;
        }

        .dashed-hr {
            border: none;
            border-top: 1px dashed #e2e8f0;
            opacity: 1;
        }

        /* Stats Badges */
        .bg-primary-subtle {
            background-color: #eef2ff !important;
            color: #4f46e5 !important;
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .icon-w {
            width: 18px;
            text-align: center;
        }

        .font-medium {
            font-weight: 500;
        }

        .coupon-card {
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
            position: relative;
        }

        .ribbon-wrapper {
            width: 100px;
            height: 100px;
            overflow: hidden;
            position: absolute;
            top: -2px;
            /* કાર્ડની બોર્ડર સાથે મેચ કરવા */
            right: -2px;
            z-index: 10;
        }

        /* Realistic Ribbon Styling */
        .ribbon {
            text-align: center;
            transform: rotate(45deg);
            position: relative;
            padding: 7px 0;
            left: -5px;
            top: 22px;
            width: 150px;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;

            /* Realistic Effects */
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.15) 100%);
            /* હળવો ગ્રેડિયન્ટ */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), inset 0 -1px 2px rgba(0, 0, 0, 0.2);
            /* 3D શેડો */
            border: 1px solid rgba(255, 255, 255, 0.15);
            /* આછી બોર્ડર */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            /* ટેક્સ્ટ શેડો */
        }

        .ribbon-wrapper::before,
        .ribbon-wrapper::after {
            content: "";
            border-top: 3px solid rgba(0, 0, 0, 0.3);
            border-left: 3px solid transparent;
            border-right: 3px solid transparent;
            position: absolute;
            z-index: -1;
        }

        .ribbon-wrapper::before {
            top: 0;
            left: 0;
        }

        /* Left side fold */
        .ribbon-wrapper::after {
            bottom: 0;
            right: 0;
        }

        /* Right side fold */

        .bg-danger-subtle {
            background-color: #fee2e2;
            border-color: #fecaca !important;
        }

        .bg-success-subtle {
            background-color: #dcfce7;
            border-color: #bbf7d0 !important;
        }

        .bg-secondary-subtle {
            background-color: #f3f4f6;
            border-color: #e5e7eb !important;
        }

        .search-box .input-group-text {
            border: 1px solid #dee2e6;
        }

        .search-box .form-control {
            border: 1px solid #dee2e6;
        }

        .modal-content {
            background-color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    @push('scripts')
    <script>
        let couponModal;

        document.addEventListener('livewire:navigated', () => {
            initModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            initModal();
        });

        function initModal() {
            const modalEl = document.getElementById('couponModal');
            if (modalEl) {
                couponModal = new bootstrap.Modal(modalEl);
            }
        }

        window.addEventListener('showModal', () => {
            if (!couponModal) initModal();
            couponModal.show();
        });

        window.addEventListener('hideModal', () => {
            if (couponModal) {
                couponModal.hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('overflow', '');
            }
        });
    </script>
    @endpush
</div>