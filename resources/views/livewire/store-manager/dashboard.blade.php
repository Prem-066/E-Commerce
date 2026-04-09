<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between bg-white p-4 rounded-4 shadow-sm border-0">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Welcome Back, Store Manager! 👋</h4>
                    <p class="text-muted mb-0"><i class="fas fa-store me-2 text-primary"></i>Managing: <span class="fw-bold text-dark">{{ $this->storeName }}</span></p>
                </div>
                <div class="d-none d-md-block">
                    <div class="text-end">
                        <span class="text-muted small d-block mb-1">Last Updated</span>
                        <span class="fw-bold text-dark">{{ now()->format('d M, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Sales -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle p-3 rounded-3 me-3">
                            <i class="fas fa-wallet fa-lg text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase">Total Revenue</p>
                            <h3 class="mb-0 fw-bold">₹{{ number_format($stats['total_sales'], 2) }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success-subtle p-3 rounded-3 me-3">
                            <i class="fas fa-shopping-cart fa-lg text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase">Total Orders</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_orders']) }}</h3>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $stats['online_orders'] }} Online</span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $stats['offline_orders'] }} POS</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning-subtle p-3 rounded-3 me-3">
                            <i class="fas fa-box-open fa-lg text-warning"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase">Total Products</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_products']) }}</h3>
                        </div>
                    </div>
                    <p class="text-muted small mb-0"><i class="fas fa-tags me-1"></i> Across {{ $stats['total_categories'] }} Categories</p>
                </div>
            </div>
        </div>

        <!-- Active Staff (Placeholder) -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger-subtle p-3 rounded-3 me-3">
                            <i class="fas fa-users fa-lg text-danger"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase">Staff Status</p>
                            <h3 class="mb-0 fw-bold text-danger">Active</h3>
                        </div>
                    </div>
                    <p class="text-muted small mb-0"><i class="fas fa-id-badge me-1"></i> Managing Store Operations</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders Table -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Recent Activity</h5>
                    <a wire:navigate.hover href="{{ route('store.manager.order.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold border">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="px-4 border-0 py-3">Order Number</th>
                                    <th class="border-0 py-3">Customer</th>
                                    <th class="border-0 py-3">Amount</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="px-4 border-0 py-3 text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-bold text-primary">#{{ $order->order_number }}</span>
                                        <div class="small text-muted text-uppercase fw-bold" style="font-size: 10px;">{{ $order->order_type }}</div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 25px; height: 25px; font-size: 10px;">
                                                {{ substr($order->customer_name, 0, 1) }}
                                            </div>
                                            <span class="fw-medium">{{ $order->customer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3 
                                            {{ $order->order_status == 'Delivered' ? 'bg-success-subtle text-success' : 
                                               ($order->order_status == 'Pending' ? 'bg-warning-subtle text-warning' : 'bg-info-subtle text-info') }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No recent orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock / Top Products -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Inventory Alert</h5>
                    <a href="{{ route('store.products') }}" class="badge bg-danger-subtle text-danger rounded-pill px-3 underline-none" style="text-decoration: none;">View All</a>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush border-0">
                        @forelse($topProducts as $product)
                        <div class="list-group-item px-0 border-0 mb-3 bg-light rounded-3 p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white p-2 rounded-2 border me-3" style="width: 50px; height: 50px;">
                                        @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-1" alt="img">
                                        @else
                                        <i class="fas fa-image text-muted d-block text-center mt-2"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 150px;">{{ $product->name }}</h6>
                                        <p class="mb-0 text-muted small">Code: {{ $product->sku }}</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-warning' }} rounded-pill">{{ $product->stock }} Left</span>
                                    <div class="small text-muted mt-1 fw-bold">₹{{ number_format($product->price, 0) }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center py-4 text-muted">All products are well stocked! ✨</p>
                        @endforelse
                    </div>
                    <a href="{{ route('store.products') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-bold mt-2 shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>Manage Inventory
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-info {
            color: #0dcaf0 !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(248, 249, 250, 1);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</div>