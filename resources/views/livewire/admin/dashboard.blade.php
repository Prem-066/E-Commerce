<div class="container-fluid pt-4">
    <h2 class="mb-4 fw-bold">Store Insights</h2>

    @if(!$storeId)
    <div class="alert alert-warning">Your Account Not Connected With Any Store.</div>
    @else
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>₹{{ number_format($stats['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM11.25 12a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM3 16.125c0 1.036.84 1.875 1.875 1.875h5.25a3.75 3.75 0 010-7.5h-5.25A1.875 1.875 0 003 12.375v3.75z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.reports.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View Reports <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>₹{{ number_format($stats['total_pending'], 0) }}</h3>
                    <p>Total Pending Amount</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM11.25 12a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM3 16.125c0 1.036.84 1.875 1.875 1.875h5.25a3.75 3.75 0 010-7.5h-5.25A1.875 1.875 0 003 12.375v3.75z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.reports.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View Reports <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_orders'] }}</h3>
                    <p>Total Orders</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                </svg>
                <a href="{{ route('admin.reports.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_products'] }}</h3>
                    <p>Total Products</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12.378 1.602a.75.75 0 00-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03zM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 00.372-.648V7.93zM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 00.372.648l8.628 5.033z"></path>
                </svg>
                <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                    Manage Inventory <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $stats['low_stock_count'] }}</h3>
                    <p>Low Stock Items</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.401 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"></path>
                </svg>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View Low Stock <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['cancelled_orders'] }}</h3>
                    <p>Cancelled Orders</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View Orders <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">Recent Orders</div>
                <div class="card-body p-0 mt-3" wire:ignore>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th class="text-center">Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach($stats['recent_orders'] as $order)
                                <tr>
                                    <td class="fw-bold text-primary">#{{ $order->order_number }}</td>

                                    <td>
                                        {{ $order->customer_name ?: 'Walk-in' }}
                                        <div class="text-muted" style="font-size: 10px;">{{ date('d M, h:i A', strtotime($order->created_at)) }}</div>
                                    </td>

                                    <td>
                                        <span class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                                        <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">{{ $order->payment_method }}</div>
                                    </td>

                                    <td class="text-center">
                                        @if($order->order_type == 'online')
                                        <span class="badge rounded-pill bg-info-subtle text-info">Online</span>
                                        @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-success">Store</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                        $statusClass = 'bg-secondary';
                                        if($order->order_status == 'Delivered') $statusClass = 'bg-success';
                                        if($order->order_status == 'Pending') $statusClass = 'bg-warning text-dark';
                                        if($order->order_status == 'Cancelled') $statusClass = 'bg-danger';
                                        if(in_array($order->order_status, ['Processing', 'Confirmed'])) $statusClass = 'bg-primary';
                                        @endphp
                                        <span class="badge {{ $statusClass }} border-0">{{ $order->order_status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">Low Stock Alerts</div>

                <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                    @forelse($stats['low_stock_products'] as $p)
                    <a wire:navigate.hover href="{{ route('admin.products', ['edit_id' => $p->id]) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded border-danger border-opacity-25 bg-danger bg-opacity-10 shadow-sm-hover" style="transition: 0.3s;">
                            <div>
                                <h6 class="mb-0 small fw-bold text-dark">{{ $p->name }}</h6>
                                <small class="fw-semibold text-white">Stock: {{ $p->stock }} Remaining</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger mb-1 d-block">Low</span>
                                <small class="text-primary" style="font-size: 10px;">Update <i class="bi bi-pencil-square"></i></small>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success fs-1"></i>
                        <p class="text-muted mt-2">All products are in good stock.</p>
                    </div>
                    @endforelse
                </div>

                @if(count($stats['low_stock_products']) > 6)
                <div class="card-footer bg-white border-0 text-center small text-muted">
                    <i class="bi bi-mouse me-1"></i> Scroll to see more
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>