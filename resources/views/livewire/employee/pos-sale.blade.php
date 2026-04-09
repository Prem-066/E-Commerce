<div class="card p-2">
    <div class="row g-3">
        <div class="col-lg-8 col-md-7">
            <div class="mb-3">
                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control border-0 ps-0" placeholder="Search product name or SKU...">
                </div>
            </div>
            <div class="product-wrapper px-1" style="height: 520px; overflow-y: auto; overflow-x: hidden;">
                <div class="row g-2 g-md-3">
                    @foreach($products as $product)
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 text-white overflow-hidden product-card"
                            wire:click="addToCart('{{ $product->id }}')"
                            style="cursor: pointer; transition: 0.3s; background-color: #374151; 
                            background-image: url('{{ $product->image ? asset('storage/' . $product->image) : 
                            asset('assets/img/wes.png') }}'); background-size: cover; background-position: center; 
                            background-blend-mode: overlay; min-height: 155px; border-radius: 12px;">

                            <div class="card-body d-flex flex-column justify-content-end p-2 p-md-3"
                                style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                <h6 class="fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ Str::limit($product->name, 15) }}
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fw-bold text-warning" style="font-size: 0.85rem;">₹{{ number_format($product->price) }}</div>
                                    <span class="badge bg-dark-soft border border-secondary" style="font-size: 0.6rem; opacity: 0.8;">
                                        S: {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px; border-radius: 15px; height: 580px; display: flex; flex-direction: column;">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i>Current Order</h6>
                    <span class="badge bg-white text-primary rounded-pill">{{ count($cart) }}</span>
                </div>

                <div class="card-body bg-light border-bottom p-3 flex-grow-0">
                    <div class="row g-2">
                        <div class="col-12 mb-1">
                            <div class="form-floating shadow-sm">
                                <input type="text" wire:model="customer_name" class="form-control border-0" id="cName" placeholder="Customer Name">
                                <label for="cName" class="small text-muted"><i class="bi bi-person me-1"></i> Customer Name</label>
                                @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-floating shadow-sm">
                                <input type="number" wire:model="customer_phone" class="form-control border-0" id="cPhone" placeholder="Phone">
                                <label for="cPhone" class="small text-muted"><i class="bi bi-telephone me-1"></i> Phone</label>
                                @error('customer_phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-7">
                            <div class="form-floating shadow-sm">
                                <input type="email" wire:model="customer_email" class="form-control border-0" id="cEmail" placeholder="Email" list="emailOptions">
                                <label for="cEmail" class="small text-muted"><i class="bi bi-envelope me-1"></i> Email Address</label>
                                @error('customer_email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0 flex-grow-1" style="overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-flush mb-0 align-middle">
                            <thead class="bg-light shadow-sm sticky-top">
                                <tr style="font-size: 0.75rem;">
                                    <th class="ps-3">Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-3">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cart as $id => $item)
                                <tr style="font-size: 0.85rem;">
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 100px;">{{ $item['name'] }}</div>
                                        <small class="text-danger" style="cursor:pointer;" wire:click="removeFromCart('{{ $id }}')">
                                            <i class="bi bi-trash"></i> Remove
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <button class="btn btn-xs btn-outline-secondary py-0 px-1" style="font-size: 0.7rem;" wire:click="decreaseQty('{{ $id }}')">-</button>
                                            <span class="fw-bold mx-1">{{ $item['qty'] }}</span>
                                            <button class="btn btn-xs btn-outline-secondary py-0 px-1" style="font-size: 0.7rem;" wire:click="addToCart('{{ $id }}')">+</button>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3 fw-bold">₹{{ number_format($item['price'] * $item['qty']) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted small">Your cart is empty</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 shadow-sm p-3 mt-auto">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-2 d-block text-uppercase" style="letter-spacing: 1px;">Payment Method</label>
                        <div class="btn-group w-100 shadow-sm" role="group">
                            <input type="radio" class="btn-check" name="pm" id="cash" value="cash" wire:model="payment_method">
                            <label class="btn btn-outline-primary btn-sm py-2" for="cash">
                                <i class="bi bi-cash-stack me-1"></i> Cash
                            </label>

                            <input type="radio" class="btn-check" name="pm" id="online" value="online" wire:model="payment_method">
                            <label class="btn btn-outline-primary btn-sm py-2" for="online">
                                <i class="bi bi-credit-card me-1"></i> Online
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <span class="text-muted fw-bold">Total Amount:</span>
                        <span class="h5 mb-0 text-primary fw-bolder">₹{{ number_format($total, 2) }}</span>
                    </div>
                    @can('create pos')
                    <button wire:click="completeSale"
                        wire:loading.attr="disabled"
                        class="btn {{ $payment_method === 'online' ? 'btn-success' : 'btn-primary' }} w-100 py-2 fw-bold shadow"
                        {{ count($cart) == 0 ? 'disabled' : '' }}>
                        <span wire:loading.remove>
                            @if($payment_method === 'online')
                            <i class="bi bi-shield-check me-2"></i> PAY & COMPLETE
                            @else
                            <i class="bi bi-printer me-2"></i> COMPLETE SALE
                            @endif
                        </span>

                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span> Processing...
                        </span>
                    </button>
                    @endcan
                </div>

            </div>
        </div>
    </div>

    <style>
        .product-wrapper::-webkit-scrollbar,
        .card-body::-webkit-scrollbar {
            width: 4px;
        }

        .product-wrapper::-webkit-scrollbar-thumb,
        .card-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
        }

        .bg-dark-soft {
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
    <hr class="my-4">

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-receipt-cutoff me-2"></i>Sales Overview
                    </h6>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary-soft text-primary px-3 py-2">
                            Total Orders: {{ count($recentOrders) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-2 mt-2" wire:ignore>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead class="bg-light text-uppercase">
                                <tr style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <th class="ps-4">Product Name</th>
                                    <th><i class="bi bi-person me-1"></i> Customer</th>
                                    <th><i class="bi bi-person-badge me-1"></i> Processed By</th>
                                    <th><i class="bi bi-wallet2 me-1"></i> Method</th>
                                    <th><i class="bi bi-currency-rupee me-1"></i> Amount</th>
                                    <th><i class="bi bi-check-circle me-1"></i> Status</th>
                                    <th><i class="bi bi-clock me-1"></i> Time</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.85rem;">
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="{{ $order->items->pluck('product.name')->implode(', ') }}">
                                            @foreach($order->items as $item)
                                            {{ $item->product->name }}{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </div>
                                        <small class="text-primary" style="font-size: 0.7rem;">#{{ $order->order_number }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $order->customer_name ?: 'Walk-in Customer' }}</span>
                                            <small class="text-muted"><i class="bi bi-telephone small me-1"></i>{{ $order->customer_phone ?: 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">
                                                {{ $order->employee->name ?? 'System' }}
                                            </span>

                                            <div class="mt-1">
                                                @php
                                                $user = $order->employee;
                                                @endphp

                                                @if($user)
                                                @if($user->hasRole('Store Manager'))
                                                <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.65rem;">
                                                    MANAGER
                                                </span>
                                                @elseif($user->hasRole('Employee POS'))
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle" style="font-size: 0.65rem;">
                                                    STAFF
                                                </span>
                                                @else
                                                <span class="badge bg-light text-muted border text-uppercase" style="font-size: 0.65rem;">
                                                    {{ $user->getRoleNames()->first() ?? 'User' }}
                                                </span>
                                                @endif
                                                @else
                                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;">
                                                    N/A
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->payment_method == 'cash')
                                        <span class="badge bg-light text-success border border-success-subtle px-2">
                                            <i class="bi bi-cash me-1"></i> CASH
                                        </span>
                                        @elseif($order->payment_method == 'upi')
                                        <span class="badge bg-light text-info border border-info-subtle px-2">
                                            <i class="bi bi-qr-code me-1"></i> UPI
                                        </span>
                                        @else
                                        <span class="badge bg-light text-primary border border-primary-subtle px-2">
                                            <i class="bi bi-credit-card me-1"></i> CARD
                                        </span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success-soft text-success border border-success-subtle">
                                            <i class="bi bi-dot fs-6"></i> Completed
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $order->created_at->format('h:i A') }}
                                        <div class="x-small text-muted">{{ $order->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-light border shadow-sm"
                                                wire:click="viewOrderDetails('{{ $order->id }}')"
                                                title="View Details">
                                                <i class="bi bi-eye text-primary"></i>
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
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                @if($selectedOrder)
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Order #{{ Str::upper(substr($selectedOrder->id, 0, 8)) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <small class="text-muted d-block">Customer</small>
                            <span class="fw-bold">{{ $selectedOrder->customer_name ?: 'Walk-in' }}</span>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Date & Time</small>
                            <span class="fw-bold">{{ $selectedOrder->created_at->format('d M, h:i A') }}</span>
                        </div>
                    </div>

                    <table class="table table-sm border-top">
                        <thead class="bg-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedOrder->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($item->qty * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Payment Method:</span>
                            <span class="text-uppercase fw-bold text-primary">{{ $selectedOrder->payment_method }}</span>
                        </div>
                        <div class="d-flex justify-content-between h5">
                            <span class="fw-bold">Grand Total:</span>
                            <span class="fw-bold text-success">₹{{ number_format($selectedOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        window.addEventListener('openModal', event => {
            let modalElement = document.getElementById('orderDetailModal');
            let myModal = bootstrap.Modal.getInstance(modalElement) ||
                new bootstrap.Modal(modalElement);
            myModal.show();
        });

        document.addEventListener('hidden.bs.modal', function(event) {
            if (document.querySelectorAll('.modal.show').length === 0) {
                let backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }
        });
    </script>

    @endpush
</div>