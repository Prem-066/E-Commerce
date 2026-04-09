<div class="content-wrapper bg-light-subtle" style="font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <div class="content-header pt-3 mb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold text-dark fs-2">Super Admin Console</h1>
                    <p class="text-muted mb-0">Ecosystem Analytics & Node Operations</p>
                </div>
            </div>
            <style>
                .nav-pills .nav-link {
                    color: #6c757d;
                    font-weight: 600;
                    border: 1px solid transparent;
                    transition: all 0.3s ease;
                }

                .nav-pills .nav-link.active {
                    background-color: #fff !important;
                    color: #0d6efd !important;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                    border: 1px solid #eee;
                }

                .avatar-group div:first-child {
                    margin-left: 0 !important;
                }

                .x-small {
                    font-size: 0.7rem;
                    letter-spacing: 0.3px;
                }

                .table-sm td {
                    padding: 0.5rem 0.3rem;
                }

                .card-outline.card-primary {
                    border-top: 3px solid #0d6efd;
                }

                .hover-border-primary:hover {
                    border-color: #0d6efd !important;
                    cursor: pointer;
                }

                .rounded-4 {
                    border-radius: 1rem !important;
                }
            </style>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row g-3 mb-4">

                <!-- Total Orders -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-dark">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Total Transactions</p>
                            <small>
                                Online: {{ $onlineOrdersCount }} | POS: {{ $offlineOrders }}
                            </small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-briefcase"></i></div>
                    </div>
                </div>

                <!-- Order Pipeline -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $pending + $confirmed + $processing }}</h3>
                            <p>Order Pipeline</p>
                            <small>
                                Pending: {{ $pending }} | Confirmed: {{ $confirmed }} | Processing: {{ $processing }}
                            </small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-activity"></i></div>
                    </div>
                </div>

                <!-- Logistics -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $shipped + $outForDelivery }}</h3>
                            <p>Logistics Hub</p>
                            <small>
                                Shipped: {{ $shipped }} | Out for Delivery: {{ $outForDelivery }}
                            </small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-truck"></i></div>
                    </div>
                </div>

                <!-- Resolution -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $delivered + $cancelled + $returned }}</h3>
                            <p>Resolution Desk</p>
                            <small>
                                Delivered: {{ $delivered }} | Cancelled: {{ $cancelled }} | Returned: {{ $returned }}
                            </small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-check-all"></i></div>
                    </div>
                </div>

                <!-- Paid Revenue -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>₹{{ number_format($paidRevenue) }}</h3>
                            <p>Paid Revenue</p>
                            <small>Cleared Payments</small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-currency-rupee"></i></div>
                    </div>
                </div>

                <!-- Risk -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>₹{{ number_format($pendingRevenue + $cancelledRevenue) }}</h3>
                            <p>Risk Amount</p>
                            <small>
                                Pending: ₹{{ number_format($pendingRevenue) }} |
                                Cancelled: ₹{{ number_format($cancelledRevenue) }}
                            </small>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-exclamation-triangle"></i></div>
                    </div>
                </div>

                <!-- Stores -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $totalStores }}</h3>
                            <p>Active Stores</p>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-shop"></i></div>
                    </div>
                </div>

                <!-- Staff -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $totalStaff }}</h3>
                            <p>Total Staff</p>
                        </div>
                        <div class="small-box-icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                </div>

            </div>

            <div class="d-flex align-items-center mb-3 mt-5">
                <div style="width: 4px; height: 20px; background: #0d6efd; border-radius: 2px;" class="me-2"></div>
                <h4 class="fw-bold m-0 text-dark">Store Deep-Dive</h4>
                <span class="badge bg-secondary-subtle text-secondary ms-2 rounded-pill px-3">{{ count($stores ?? []) }} Active Shops</span>
            </div>

            <div class="row g-4 mb-5">
                @foreach($stores as $store)
                <div class="col-xl-6">
                    <div class="card card-outline card-primary shadow-sm h-100 border-0">
                        <div class="card-header bg-white border-bottom pt-3 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 50px; height: 50px;">
                                        <i class="bi bi-shop fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0 text-dark">{{ $store->name }}</h5>
                                        <span class="badge bg-success-subtle text-success x-small border border-success-subtle mt-1">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> Live Node
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-pill border" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item small" href="#"><i class="bi bi-eye me-2"></i>View Full Report</a></li>
                                        <li><a class="dropdown-item small" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-4 py-3">
                            <div class="row g-2 mb-4">
                                <div class="col-6 col-md-3">
                                    <div class="p-2 border rounded-3 bg-primary-subtle border-primary-subtle">
                                        <label class="text-primary x-small d-block fw-bold text-uppercase">Today's Sale</label>
                                        <span class="h6 fw-bold mb-0 text-dark">₹{{ number_format($store->stats['today_revenue'] ?? 0, 0) }}</span>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="p-2 border rounded-3 bg-warning-subtle border-warning-subtle">
                                        <label class="text-warning x-small d-block fw-bold text-uppercase">Pending</label>
                                        <span class="h6 fw-bold mb-0 text-dark">{{ $store->stats['pending_orders'] ?? 0 }}</span>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="p-2 border rounded-3 bg-success-subtle border-success-subtle">
                                        <label class="text-success x-small d-block fw-bold text-uppercase">Completed</label>
                                        <span class="h6 fw-bold mb-0 text-dark">{{ $store->stats['completed_orders'] ?? 0 }}</span>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="p-2 border rounded-3 bg-danger-subtle border-danger-subtle">
                                        <label class="text-danger x-small d-block fw-bold text-uppercase">Cancelled</label>
                                        <span class="h6 fw-bold mb-0 text-dark">{{ $store->stats['cancelled_orders'] ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-light rounded-pill mb-4" id="storeTab{{ $store->id }}" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#orders-{{ $store->id }}">Recent Orders</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#products-{{ $store->id }}">Top Products</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="orders-{{ $store->id }}">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless align-middle mb-0">
                                            <thead class="text-muted x-small text-uppercase border-bottom">
                                                <tr>
                                                    <th>Customer / Time</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse(($store->recent_orders ?? collect()) as $order)
                                                <tr>
                                                    <td class="py-2">
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                                {{ $order->customer_name ?? 'Guest Customer' }}
                                                            </span>

                                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                                <i class="bi bi-telephone-outbound me-1" style="font-size: 0.7rem;"></i>
                                                                {{ $order->customer_phone ?? 'No Contact' }}
                                                            </span>

                                                            <span class="text-uppercase fw-medium mt-1" style="font-size: 0.65rem; color: #adb5bd;">
                                                                {{ $order->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status_color }}-subtle text-{{ $order->status_color }} x-small px-2">
                                                            {{ strtoupper($order->payment_status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end small fw-bold text-dark">₹{{ number_format($order->total_amount, 0) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted small py-3">No recent orders</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="products-{{ $store->id }}">
                                    <div class="list-group list-group-flush">
                                        @forelse(($store->top_selling_products ?? collect())->take(3) as $product)
                                        <div class="list-group-item px-0 py-2 border-0 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary-subtle rounded p-1 me-2">
                                                    <i class="bi bi-box small text-secondary"></i>
                                                </div>
                                                <div>
                                                    <div class="small fw-bold text-dark">{{ $product->name }}</div>
                                                    <div class="x-small text-muted">{{ $product->sales_count ?? 0 }} units sold</div>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill x-small">Top Seller</span>
                                        </div>
                                        @empty
                                        <div class="text-center text-muted small py-3">No product data available</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="x-small fw-bold text-muted text-uppercase">POS Capacity</span>
                                    <span class="x-small fw-bold text-dark">{{ $store->employees_count ?? 0 }}/5 Units</span>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 10px;">
                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                        style="width: {{ min((($store->employees_count ?? 0)/5)*100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top-0 px-4 pb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="avatar-group d-flex align-items-center">
                                    @foreach(($store->managers ?? collect())->take(3) as $mgr)
                                    <div class="bg-dark text-white rounded-circle border border-2 border-white d-flex align-items-center justify-content-center x-small shadow-sm"
                                        style="width: 32px; height: 32px; margin-left: -10px; cursor: pointer;" title="{{ $mgr->name }}">
                                        {{ strtoupper(substr($mgr->name, 0, 1)) }}
                                    </div>
                                    @endforeach

                                    @php $remaining = ($store->manager_count ?? 0) - 3; @endphp
                                    @if($remaining > 0)
                                    <div class="bg-light text-muted rounded-circle border border-2 border-white d-flex align-items-center justify-content-center x-small"
                                        style="width: 32px; height: 32px; margin-left: -10px; font-size: 10px;">
                                        +{{ $remaining }}
                                    </div>
                                    @endif
                                </div>
                                <a href="{{ route('superadmin.stores.edit', $store->id) }}"
                                    wire:navigate
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                                    Manage <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex align-items-center mb-3 mt-5">
                <div style="width: 4px; height: 20px; background: #ffba00; border-radius: 2px;" class="me-2"></div>
                <h4 class="fw-bold m-0 text-dark">Online Orders Management</h4>
                <span class="badge bg-warning-subtle text-warning ms-2 rounded-pill px-3">{{ count($onlineOrders ?? []) }} Live Transmissions</span>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive" wire:ignore>
                        <table id="dataTable" class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Order Node</th>
                                    <th>Customer Identity</th>
                                    <th>Status Matrix</th>
                                    <th>Payment</th>
                                    <th class="text-end pe-4">Total Energy (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($onlineOrders as $ord)
                                <tr style="cursor: pointer;" wire:click="viewOrder('{{ $ord->id }}')">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 38px; height: 38px; font-size: 10px;">
                                                #{{ substr($ord->order_number, -4) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $ord->order_number }}</div>
                                                <div class="x-small text-muted">{{ $ord->created_at->format('M d, H:i') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $ord->customer_name }} {{ $ord->customer_last_name }}</div>
                                        <div class="x-small text-muted"><i class="bi bi-phone me-1"></i>{{ $ord->customer_phone }}</div>
                                    </td>
                                    <td>
                                        @php
                                        $statusColor = match($ord->order_status) {
                                        'Delivered' => 'success',
                                        'Shipped' => 'info',
                                        'Processing' => 'primary',
                                        'Pending' => 'warning',
                                        default => 'secondary'
                                        };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">
                                            {{ strtoupper($ord->order_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center fw-bold text-dark small">
                                            <i class="bi bi-{{ $ord->payment_method == 'cod' ? 'cash' : 'credit-card' }} me-2 text-{{ $ord->payment_status == 'completed' ? 'success' : 'danger' }}"></i>
                                            {{ strtoupper($ord->payment_status) }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="h6 fw-bold text-dark">₹{{ number_format($ord->total_amount, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">No online orders found in the matrix.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Full Detail Modal -->
            <div wire:ignore.self class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        @if($selectedOrder)
                        <div class="modal-header border-bottom-0 bg-dark text-white p-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cpu fs-3 me-3 text-warning"></i>
                                <div>
                                    <h5 class="modal-title fw-bold">Order Transmission #{{ $selectedOrder->order_number }}</h5>
                                    <p class="mb-0 x-small text-white-50">Global Node: {{ $selectedOrder->id }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" wire:click="closeOrder"></button>
                        </div>
                        <div class="modal-body p-4 bg-light-subtle">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-xs rounded-3 p-3">
                                        <h6 class="text-muted text-uppercase x-small fw-bold mb-3 ls-1">Customer Profile</h6>
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $selectedOrder->customer_name }} {{ $selectedOrder->customer_last_name }}</div>
                                                <div class="small text-muted">{{ $selectedOrder->customer_email }}</div>
                                                <div class="small text-muted">{{ $selectedOrder->customer_phone }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 border-light">
                                        <div class="small text-dark fw-bold mb-1">Shipping Log:</div>
                                        <div class="small text-muted">
                                            <i class="bi bi-geo-alt me-2"></i>{{ $selectedOrder->address }}<br>
                                            {{ $selectedOrder->city }}, {{ $selectedOrder->zip_code }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-xs rounded-3 p-3">
                                        <h6 class="text-muted text-uppercase x-small fw-bold mb-3 ls-1">Transactional State</h6>
                                        <div class="list-group list-group-flush small">
                                            <div class="list-group-item px-0 d-flex justify-content-between border-0 bg-transparent">
                                                @php
                                                $selectedStatusColor = match($selectedOrder->order_status) {
                                                'Delivered' => 'success',
                                                'Shipped' => 'info',
                                                'Processing' => 'primary',
                                                'Pending' => 'warning',
                                                'Cancelled' => 'danger',
                                                'Returned' => 'secondary',
                                                default => 'secondary'
                                                };
                                                @endphp
                                                <span class="text-muted">Order Status:</span>
                                                <span class="fw-bold text-{{ $selectedStatusColor }}">{{ strtoupper($selectedOrder->order_status) }}</span>
                                            </div>
                                            <div class="list-group-item px-0 d-flex justify-content-between border-0 bg-transparent">
                                                <span class="text-muted">Payment Status:</span>
                                                <span class="fw-bold text-{{ $selectedOrder->payment_status == 'completed' ? 'success' : 'warning' }}">{{ strtoupper($selectedOrder->payment_status) }}</span>
                                            </div>
                                            <div class="list-group-item px-0 d-flex justify-content-between border-0 bg-transparent">
                                                <span class="text-muted">Payment Method:</span>
                                                <span class="fw-bold text-dark">{{ strtoupper($selectedOrder->payment_method) }}</span>
                                            </div>
                                            <div class="list-group-item px-0 d-flex justify-content-between border-0 bg-transparent">
                                                <span class="text-muted">Tracking ID:</span>
                                                <span class="fw-bold text-muted">{{ $selectedOrder->payment_id ?: 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-xs rounded-3 p-3 mb-4">
                                <h6 class="text-muted text-uppercase x-small fw-bold mb-3 ls-1">Inventory Manifest</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                        <thead class="x-small text-muted border-bottom">
                                            <tr>
                                                <th>Item Node</th>
                                                <th class="text-center">Oty</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selectedOrder->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('storage/'.$item->image) }}"
                                                            style="width:40px; height:40px; object-fit:cover; border-radius:6px;">
                                                        <div>
                                                            <div class="fw-bold text-dark">{{ $item->name }}</div>
                                                            <div class="x-small text-muted">SKU: {{ $item->sku }}</div>
                                                        </div>
                                                    </div>  
                                                </td>
                                                <td class="text-center fw-bold">{{ $item->qty }}</td>
                                                <td class="text-center">
                                                    @php
                                                    $itemColor = match($item->status) {
                                                    'Delivered' => 'success',
                                                    'Cancelled' => 'danger',
                                                    'Returned' => 'secondary',
                                                    default => 'info'
                                                    };
                                                    @endphp
                                                    <span class="badge bg-{{ $itemColor }}-subtle text-{{ $itemColor }} x-small px-2">
                                                        {{ $item->status ?? 'Active' }}
                                                    </span>
                                                </td>
                                                <td class="text-end fw-bold">₹{{ number_format($item->price, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($selectedOrder->order_notes)
                            <div class="alert alert-warning border-0 shadow-xs rounded-3 d-flex align-items-start small">
                                <i class="bi bi-sticky-fill me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block mb-1">Transmission Note:</strong>
                                    {{ $selectedOrder->order_notes }}
                                </div>
                            </div>
                            @endif


                            <div class="bg-white rounded-3 p-3 shadow-xs">
                                <div class="d-flex justify-content-between x-small mb-1">
                                    <span class="text-muted fw-bold">Subtotal Manifest:</span>
                                    <span class="fw-bold text-dark">₹{{ number_format($selectedOrder->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between x-small mb-1">
                                    <span class="text-muted fw-bold">Logistics Energy:</span>
                                    <span class="text-success fw-bold">+₹{{ number_format($selectedOrder->shipping_charges, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                    <h6 class="fw-bold text-dark mb-0">Total Node Extraction:</h6>
                                    <h5 class="fw-bold text-primary mb-0">₹{{ number_format($selectedOrder->total_amount, 2) }}</h5>
                                </div>
                                @if($selectedOrder->coupon_code)
                                <div class="alert alert-info mt-2">
                                    Coupon: <b>{{ $selectedOrder->coupon_code }}</b><br>
                                    Discount: ₹{{ number_format($selectedOrder->coupon_discount,2) }}
                                </div>
                                @endif

                                @if($selectedOrder->redeemed_details)
                                <div class="alert alert-success mt-2">
                                    Redeemed: {{ $selectedOrder->redeemed_details->points }} Points
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <style>
                /* AdminLTE Small Box Core */
                .small-box {
                    border-radius: 0.35rem;
                    position: relative;
                    display: block;
                    margin-bottom: 20px;
                    overflow: hidden;
                }

                .small-box>.inner {
                    padding: 15px;
                    position: relative;
                    z-index: 2;
                }

                .small-box h3 {
                    font-size: 2rem;
                    font-weight: 700;
                    margin: 0 0 5px 0;
                    white-space: nowrap;
                    padding: 0;
                }

                .small-box .small-box-icon {
                    position: absolute;
                    top: 5px;
                    right: 15px;
                    z-index: 0;
                    font-size: 4.5rem;
                    color: rgba(0, 0, 0, 0.15);
                    transition: transform 0.3s linear;
                }

                .small-box:hover .small-box-icon {
                    transform: scale(1.1);
                }

                .small-box>.small-box-footer {
                    position: relative;
                    text-align: center;
                    padding: 4px 0;
                    display: block;
                    z-index: 10;
                    background: rgba(0, 0, 0, 0.1);
                    text-decoration: none;
                    font-size: 0.85rem;
                }

                /* Card Outline Feature */
                .card-outline.card-primary {
                    border-top: 4px solid #0d6efd !important;
                }

                /* Helpers */
                .ls-1 {
                    letter-spacing: 0.05rem;
                }

                .x-small {
                    font-size: 0.65rem;
                }

                .shadow-xs {
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                }

                .status-dot {
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    display: inline-block;
                }

                .hover-border-primary:hover {
                    border-color: #0d6efd !important;
                    cursor: pointer;
                }
            </style>
        </div>
    </div>
    @push('scripts')
    <script>
        let orderModal;
        document.addEventListener('livewire:navigated', () => {
            initModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            initModal();
        });

        function initModal() {
            const modalElement = document.getElementById('orderDetailModal');
            if (modalElement) {
                orderModal = new bootstrap.Modal(modalElement);
            }
        }

        window.addEventListener('open-order-modal', event => {
            if (!orderModal) initModal();
            orderModal.show();
        });

        window.addEventListener('close-order-modal', event => {
            if (orderModal) orderModal.hide();
        });
    </script>
    @endpush
</div>