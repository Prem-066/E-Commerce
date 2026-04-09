<div class="container-fluid pt-4">
    <div class="row g-3">
        <div class="col-md-3">
            <button class="btn btn-dark w-100 d-md-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilters">
                <i class="bi bi-funnel"></i> Show/Hide Filters
            </button>

            <div class="collapse d-md-block sticky-top" id="mobileFilters" style="top: 20px;">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white fw-bold d-none d-md-block">Advanced Filters</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small fw-bold">Date Range</label>
                            <div class="row g-2">
                                <div class="col-6 col-md-12">
                                    <input type="date" wire:model.live="startDate" class="form-control form-control-sm">
                                </div>
                                <div class="col-6 col-md-12">
                                    <input type="date" wire:model.live="endDate" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        @if(!$isAdmin)
                        <div class="mb-3">
                            <label class="small fw-bold">Select Store</label>
                            <select wire:model.live="selectedStore" class="form-select form-select-sm">
                                <option value="">All Stores</option>
                                @foreach($allStores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="small fw-bold">Staff / Admin / Manager</label>
                            <select wire:model.live="selectedUser" class="form-select form-select-sm">
                                <option value="">All Personnel</option>
                                @foreach($allUsers as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                    @if(method_exists($user, 'getRoleName'))
                                    ({{ $user->getRoleName() }})
                                    @elseif(method_exists($user, 'getRoleNames'))
                                    ({{ $user->getRoleNames()->first() }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>₹{{ number_format($totalRevenue, 0) }}</h3>
                            <p>Total Sales</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                        </svg>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Total Orders</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>₹{{ number_format($cashSales, 0) }}</h3>
                            <p>Cash Payments</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM11.25 12a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM3 16.125c0 1.036.84 1.875 1.875 1.875h5.25a3.75 3.75 0 010-7.5h-5.25A1.875 1.875 0 003 12.375v3.75z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>₹{{ number_format($onlineSales, 0) }}</h3>
                            <p>Online Payments</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"></path>
                        </svg>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0" wire:ignore>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="bg-light small text-uppercase">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>Location (Store)</th>
                                    <th>Customer</th>
                                    <th>Handled By</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach($reports as $order)
                                <tr>
                                    <td>{{ $order->created_at->format('d/m/y | h:i A') }}</td>
                                    <td><span class="badge bg-secondary">{{ $order->store->name ?? 'Main Office' }}</span></td>
                                    <td>
                                        <div class="fw-bold">{{ $order->customer_name ? trim($order->customer_name . ' ' . $order->customer_last_name) : 'Walk-in Customer' }}</div>
                                        @if($order->customer_phone)
                                        <small class="text-muted"><i class="bi bi-telephone small"></i> {{ $order->customer_phone }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="fw-bold text-primary">{{ $order->employee->name ?? 'System' }}</div>
                                        <small class="text-muted">ID: #{{ $order->employee->id ?? '0' }}</small>
                                    </td>
                                    <td class="text-end fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="text-center">
                                        <button wire:click="viewOrderDetails('{{ $order->id }}')"
                                            class="btn btn-sm btn-outline-primary shadow-none border-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content border-0 shadow-lg">
                @if($selectedOrder)

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Order Details #{{ Str::upper(substr($selectedOrder->id, 0, 8)) }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Store/Location</small>
                            <span class="fw-bold">{{ $selectedOrder->store->name ?? 'Main Branch' }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block">Handled By</small>
                            <span class="fw-bold">{{ $selectedOrder->employee->name ?? 'System' }}</span>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Customer:</span>
                            <span class="fw-bold small">{{ $selectedOrder->customer_name ? trim($selectedOrder->customer_name . ' ' . $selectedOrder->customer_last_name) : 'Walk-in Customer' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Date:</span>
                            <span class="fw-bold small">{{ $selectedOrder->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr class="small text-uppercase">
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedOrder->items as $item)
                            <tr class="small">
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($item->qty * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Payment Method:</span>
                            <span class="badge bg-info-soft text-dark border">{{ strtoupper($selectedOrder->payment_method) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary fw-semibold">Status:</span>
                            <span class="badge {{ in_array($selectedOrder->order_status, ['Cancelled','Returned']) ? 'bg-danger' : 'bg-primary' }} text-white border-0 text-uppercase fw-bold">{{ strtoupper($selectedOrder->order_status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between h5 mb-0">
                            <span class="fw-bold">Grand Total:</span>
                            <span class="fw-bold text-success">₹{{ number_format($selectedOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('openModal', event => {
            let modalElement = document.getElementById('orderDetailModal');
            let myModal = new bootstrap.Modal(modalElement);
            myModal.show();
        });

        document.addEventListener('DOMContentLoaded', function() {
            let modalElement = document.getElementById('orderDetailModal');

            modalElement.addEventListener('hidden.bs.modal', function() {
                $('.modal-backdrop').remove();

                $('body').removeClass('modal-open').css({
                    'overflow': '',
                    'padding-right': ''
                });

            });
        });
    </script>
    @endpush
</div>