<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Order Management</h5>
                        <p class="text-muted small mb-0">Manage and track your store orders efficiently</p>
                    </div>
                </div>
                <div class="card-body p-0" wire:ignore>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover align-middle mb-0" style="min-width: 1000px;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 text-uppercase small fw-bold text-muted" style="min-width: 150px;">Order & Date</th>
                                    <th class="text-uppercase small fw-bold text-muted" style="min-width: 180px;">Customer</th>
                                    <th class="text-uppercase small fw-bold text-muted" style="min-width: 250px;">Products Details</th>
                                    <th class="text-uppercase small fw-bold text-muted text-center">Type</th>
                                    <th class="text-uppercase small fw-bold text-muted">Amount</th>
                                    <th class="text-uppercase small fw-bold text-muted">Payment</th>
                                    <th class="text-uppercase small fw-bold text-muted" style="min-width: 160px;">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr wire:key="order-row-{{ $order->id }}">
                                    <td class="px-4">
                                        <span class="fw-bold text-primary">#{{ $order->order_number }}</span>
                                        <div class="mt-2 text-muted" style="font-size: 11px;">
                                            <i class="far fa-calendar-alt me-1"></i> {{ date('d M, Y', strtotime($order->created_at)) }}<br>
                                            <i class="far fa-clock me-1 mt-1"></i> {{ date('h:i A', strtotime($order->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold text-dark">{{ $order->customer_name }} {{ $order->customer_last_name }}</div>
                                            <small class="text-muted"><i class="far fa-envelope me-1"></i>{{ $order->customer_email }}</small>
                                            <small class="text-muted mt-1"><i class="fas fa-phone-alt me-1" style="font-size: 10px;"></i>{{ $order->customer_phone }}</small>
                                            @if ($order->city)
                                            <span class="text-dark small fw-medium text-truncate mt-1" style="max-width: 150px;">
                                                <i class="fas fa-map-marker-alt me-1 text-muted small"></i>{{ $order->city }}
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pe-2" style="max-height: 140px; overflow-y: auto;">
                                            @foreach($order->items as $item)
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                                                <div style="font-size: 12px; line-height: 1.3;">
                                                    <span class="text-dark fw-bold d-block text-truncate" style="max-width: 150px;" title="{{ $item->product ? $item->product->name : 'Deleted Product' }}">{{ $item->product ? $item->product->name : 'Deleted Product' }}</span>
                                                    <div class="text-muted mt-1">Qty: <b>{{ $item->qty }}</b> | ₹{{ number_format($item->price, 2) }}</div>
                                                </div>
                                                @if($order->items->count() > 1)

                                                <div class="ms-3 d-flex flex-column align-items-end" style="min-width: 110px;">
                                                    <div class="text-muted mb-1" style="font-size: 8px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600; white-space: nowrap;">Item Status</div>
                                                    @php
                                                    $statusClass = 'text-info bg-info bg-opacity-10';
                                                    if($item->status == 'Cancelled') $statusClass = 'text-danger bg-danger bg-opacity-10';
                                                    if(in_array($item->status, ['Returned', 'Refunded'])) $statusClass = 'text-warning bg-warning bg-opacity-10';
                                                    if($item->status == 'Delivered') $statusClass = 'text-success bg-success bg-opacity-10';
                                                    if(in_array($item->status, ['Processing', 'Confirmed', 'Out for Delivery'])) $statusClass = 'text-primary bg-primary bg-opacity-10';
                                                    @endphp
                                                    @can('edit orders')
                                                    <div class="position-relative w-100" wire:loading.class="opacity-50">
                                                        <select class="form-select form-select-sm {{ $statusClass }} border-0 fw-bold shadow-sm"
                                                            style="font-size: 10px; cursor: pointer; border-radius: 6px; padding: 4px 8px; height: 28px; color: #333 !important;"
                                                            wire:loading.attr="disabled"
                                                            wire:change="updateOrderItemStatus('{{ $item->id }}', $event.target.value)">
                                                            <option value="Ordered" class="text-dark bg-white" {{ $item->status == 'Ordered' ? 'selected' : '' }}>📦 Ordered</option>
                                                            <option value="Confirmed" class="text-dark bg-white" {{ $item->status == 'Confirmed' ? 'selected' : '' }}>✔️ Confirmed</option>
                                                            <option value="Processing" class="text-dark bg-white" {{ $item->status == 'Processing' ? 'selected' : '' }}>⚙️ Processing</option>
                                                            <option value="Out for Delivery" class="text-dark bg-white" {{ $item->status == 'Out for Delivery' ? 'selected' : '' }}>🚚 Out for Delivery</option>
                                                            <option value="Delivered" class="text-dark bg-white" {{ $item->status == 'Delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                                            <option value="Cancelled" class="text-dark bg-white" {{ $item->status == 'Cancelled' ? 'selected' : '' }}>🚫 Cancelled</option>
                                                            <option value="Returned" class="text-dark bg-white" {{ $item->status == 'Returned' ? 'selected' : '' }}>↩️ Returned</option>
                                                        </select>
                                                    </div>
                                                    @else
                                                    <span class="badge {{ $statusClass }} " style="font-size: 10px; border-radius: 6px; padding: 5px 10px;">{{ $item->status }}</span>
                                                    @endcan
                                                </div>
                                                @else
                                                <div class="ms-3 d-flex flex-column align-items-end">
                                                    @php
                                                    $badgeClass = 'badge-info bg-info bg-opacity-10 text-info';
                                                    if($item->status == 'Cancelled') $badgeClass = 'bg-danger bg-opacity-10 text-danger';
                                                    if($item->status == 'Returned') $badgeClass = 'bg-warning bg-opacity-10 text-warning';
                                                    if($item->status == 'Delivered') $badgeClass = 'bg-success bg-opacity-10 text-success';
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} text-dark" style="font-size: 10px; border-radius: 6px; padding: 5px 10px;">
                                                        {{ $item->status }}
                                                    </span>
                                                </div>
                                                @endif

                                            </div>
                                            @endforeach


                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($order->order_type == 'online')
                                        <span class="badge rounded-pill bg-info-subtle text-info px-3">
                                            <i class="fas fa-globe me-1 small"></i> Online
                                        </span>
                                        @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-success px-3">
                                            <i class="fas fa-store me-1 small"></i> Store
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</div>
                                    </td>
                                    <td>
                                        <div class="status-select-wrapper">
                                            @can('edit orders')
                                            <select class="form-select border-0 shadow-sm status-dropdown-select status-{{ strtolower($order->payment_status) }}" style="font-size:12px;"
                                                wire:change="updatePaymentStatus('{{ $order->id }}', $event.target.value)">
                                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>⏳ pending</option>
                                                <option value="unpaid" {{ $order->payment_status == 'Unpaid' ? 'selected' : '' }}>❌ Unpaid</option>
                                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>💳 paid</option>
                                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>❌ failed</option>
                                                <option value="Refunded" {{ $order->payment_status == 'Refunded' ? 'selected' : '' }}> 💰 Refunded</option>
                                            </select>
                                            @endcan
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">
                                                    {{ $order->payment_method == 'cod' ? 'Cash On Delivery' : $order->payment_method }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="min-width: 160px;">
                                        <div class="status-select-wrapper">
                                            @can('edit orders')
                                            <select class="form-select border-0 shadow-sm status-dropdown-select status-{{ strtolower(str_replace(' ', '-', $order->order_status)) }}" style="font-size:12px;"
                                                wire:change="updateStatus('{{ $order->id }}', $event.target.value)">
                                                <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                <option value="Confirmed" {{ $order->order_status == 'Confirmed' ? 'selected' : '' }}>✔️ Confirmed</option>
                                                <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>⚙️ Processing</option>
                                                <option value="Out for Delivery" {{ $order->order_status == 'Out for Delivery' ? 'selected' : '' }}>🚚 Out for Delivery</option>
                                                <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                                <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>🚫 Cancelled</option>
                                                <option value="Returned" {{ $order->order_status == 'Returned' ? 'selected' : '' }}>↩️ Returned</option>
                                            </select>
                                            @endcan
                                            @if (!auth()->user()->can('edit orders'))
                                            <span class="badge rounded-pill bg-secondary-subtle text-success px-3">
                                                <i class="fas fa-store me-1 small"></i> {{ $order->order_status }}
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <div class="mb-3">
                                            <i class="fas fa-receipt fa-4x opacity-25"></i>
                                        </div>
                                        <h6 class="fw-bold">No orders found</h6>
                                        <p class="mb-0 small">No orders match your current criteria</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .status-dropdown-select {
            width: auto !important;
            min-width: 130px;
            max-width: 150px;
            padding: 4px 8px;
            display: inline-block;
        }

        .status-select-wrapper {
            width: fit-content;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        /* Payment Status Colors */
        .status-paid {
            background-color: #d1e7dd;
            color: #0f5132;
            border-color: #badbcc;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #842029;
            border-color: #f5c2c7;
        }

        .status-refunded {
            background-color: #e2e3e5;
            color: #41464b;
            border-color: #d3d3d4;
        }

        .status-unpaid {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        /* Order Status Additional Colors */
        .status-confirmed {
            background-color: #d1e7dd;
            color: #0f5132;
            border-color: #badbcc;
        }

        .status-out-for-delivery {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
            border-color: #f5c2c7;
        }

        .status-returned {
            background-color: #f8d7da;
            color: #842029;
            border-color: #f5c2c7;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
            border-color: #b6d4fe;
        }

        .status-shipped {
            background-color: #e0e0e0;
            color: #424242;
            border-color: #bdbdbd;
        }

        .status-delivered {
            background-color: #d1e7dd;
            color: #0f5132;
            border-color: #badbcc;
        }

        .date-badge {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-block;
            border: 1px solid #eee;
            min-width: 135px;
        }

        .status-dropdown-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0;
            transition: all 0.2s;
        }

        .hover-primary:hover {
            background-color: #e7f1ff;
            color: #0d6efd;
            border-color: #0d6efd !important;
        }

        .hover-danger:hover {
            background-color: #fff1f0;
            border-color: #dc3545 !important;
        }

        .badge {
            font-size: 0.7rem;
            font-weight: 700;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.5rem;
        }

        #dataTable_wrapper .row {
            padding: 1rem 1.25rem;
        }
    </style>
</div>