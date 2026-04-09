<div class="card p-3 border-0 shadow-sm">
    <div class="row mb-4 align-items-center">
        <div class="col-sm-6">
            <h3 class="fw-bold">Welcome, {{ auth()->user()->name }} 👋</h3>
            <p class="text-muted small mb-0">Here is what's happening in your store today.</p>
        </div>
        <div class="col-sm-6 text-end">
            <a wire:navigate.hover href="{{ route('employee.pos') }}" class="btn btn-primary shadow-sm px-4">
                <i class="bi bi-plus-circle me-1"></i> New Sale
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary shadow-sm">
                <div class="inner">
                    <h3>₹{{ number_format($todaySales) }}</h3>
                    <p>Today's Sales</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM2.25 16.5v2.625c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125V16.5h-21zM21.75 6.75v7.5H2.25v-7.5c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125z" clip-rule="evenodd"></path>
                </svg>
                <a wire:navigate href="{{ route('superadmin.reports.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View Reports <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning shadow-sm">
                <div class="inner text-dark">
                    <h3>₹{{ number_format($cashInHand) }}</h3>
                    <p>Cash in Hand</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3h6.75a.375.375 0 01.375.375v9a.375.375 0 01-.375.375h-6.75a.375.375 0 01-.375-.375v-9a.375.375 0 01.375-.375z"></path>
                </svg>
                <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                    Cash Details <i class="bi bi-info-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box text-bg-info shadow-sm">
                <div class="inner">
                    <h3>₹{{ number_format($onlinePayment) }}</h3>
                    <p>Online Payment</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM7.5 9A1.5 1.5 0 019 7.5h7.5a1.5 1.5 0 011.5 1.5v6a1.5 1.5 0 01-1.5 1.5H9A1.5 1.5 0 017.5 15V9zm6.75 3a.75.75 0 100-1.5.75.75 0 000 1.5z"></path>
                </svg>
                <a wire:navigate href="{{ route('employee.inventory') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    Check Stock <i class="bi bi-exclamation-octagon"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box text-bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $todayOrders }}</h3>
                    <p>Total Orders</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                </svg>
                <a wire:navigate href="{{ route('employee.pos') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    New Order <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>



        <div class="col-lg-2 col-6">
            <div class="small-box text-bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ $lowStockCount }}</h3>
                    <p>Low Stock Items</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"></path>
                </svg>
                <a wire:navigate href="{{ route('employee.inventory') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    Check Stock <i class="bi bi-exclamation-octagon"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-md-8 border-end">
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 fw-bold">Recent Transactions</h5>
                            <span class="badge bg-light text-dark border small">Today</span>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th class="ps-3 border-0 small text-uppercase">Order Details</th>
                                        <th class="border-0 small text-uppercase">Customer</th>
                                        <th class="border-0 small text-uppercase">Created By</th>
                                        <th class="border-0 small text-uppercase">Payment</th>
                                        <th class="text-end pe-3 border-0 small text-uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-primary">#{{ $order->order_number }}</div>
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $order->customer_name ?: 'Walk-in Customer' }}</div>
                                            @if($order->customer_phone)
                                            <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $order->customer_phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 25px; height: 25px;">
                                                    <i class="bi bi-person text-secondary" style="font-size: 12px;"></i>
                                                </div>
                                                <span class="small fw-semibold">{{ $order->employee->name ?? 'System' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill {{ $order->payment_method == 'cash' ? 'bg-info-subtle text-info border border-info' : 'bg-primary-subtle text-primary border border-primary' }} px-3" style="font-size: 10px;">
                                                {{ strtoupper($order->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</div>
                                            <small class="text-success" style="font-size: 11px;">Completed</small>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">No transactions today.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 bg-light bg-opacity-10">
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 fw-bold text-danger">Low Stock Alerts</h5>
                            <i class="bi bi-exclamation-triangle text-danger"></i>
                        </div>

                        <div style="max-height: 480px; overflow-y: auto; scrollbar-width: thin;">
                            @forelse($low_stock_products as $p)
                            <a wire:navigate.hover href="{{ route('employee.store.products', ['edit_id' => $p->id]) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded border-danger border-opacity-10 bg-white shadow-sm shadow-sm-hover transition-all">
                                    <div class="text-truncate me-2">
                                        <h6 class="mb-0 small fw-bold text-dark text-truncate">{{ $p->name }}</h6>
                                        <small class="text-danger fw-semibold" style="font-size: 11px;">Stock: {{ $p->stock }} Left</small>
                                    </div>
                                    <div class="text-end flex-shrink-0">
                                        <span class="badge bg-danger rounded-pill mb-1" style="font-size: 9px;">LOW</span>
                                        <small class="text-primary d-block" style="font-size: 9px;">Update <i class="bi bi-pencil-square"></i></small>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle text-success fs-1"></i>
                                <p class="text-muted mt-2 small">All products are in good stock.</p>
                            </div>
                            @endforelse
                        </div>

                        @if(count($low_stock_products) > 6)
                        <div class="text-center mt-3 pt-2 border-top">
                            <small class="text-muted" style="font-size: 11px;"><i class="bi bi-arrow-down-up me-1"></i> Scroll to view all</small>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>