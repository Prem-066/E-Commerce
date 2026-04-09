@extends('fronend.partials.app')
@section('title', 'My Order History')
@section('contentt')
<style>
    .order-card {
        border-radius: 15px;
        transition: 0.3s;
        border: 1px solid #eee;
        background: #fff;
    }

    .order-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .status-badge {
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-pending {
        background: #fff4e5;
        color: #ff9800;
    }

    .status-processing {
        background: #e3f2fd;
        color: #2196f3;
    }

    .status-shipped {
        background: #f3e5f5;
        color: #9c27b0;
    }

    .status-delivered {
        background: #e8f5e9;
        color: #4caf50;
    }

    /* Icon Style Tracking CSS */
    .order-tracking-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        padding-top: 20px;
        padding-bottom: 40px;
    }

    .tracking-step {
        text-align: center;
        width: 100%;
        position: relative;
        z-index: 2;
    }

    .tracking-icon {
        width: 32px;
        height: 32px;
        background: #eee;
        color: #888;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: 0.3s;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #eee;
    }

    .tracking-step.active .tracking-icon,
    .tracking-step.completed .tracking-icon {
        background: #28a745;
        color: #fff;
        box-shadow: 0 0 0 1px #28a745;
    }

    .tracking-label {
        font-size: 11px;
        font-weight: 700;
        color: #888;
        position: absolute;
        width: 100%;
        left: 0;
        top: 38px;
        transition: 0.3s;
    }

    .tracking-step.active .tracking-label,
    .tracking-step.completed .tracking-label {
        color: #28a745;
    }

    .tracking-line-container {
        position: absolute;
        top: 36px;
        left: 10%;
        width: 80%;
        height: 2px;
        background: #eee;
        z-index: 1;
    }

    .tracking-line-fill {
        height: 100%;
        background: #28a745;
        transition: width 1.5s ease-in-out;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .order-card {
            padding: 20px !important;
            text-align: center;
        }

        .order-card .col-md-3,
        .order-card .col-md-5,
        .order-card .col-md-2 {
            margin-bottom: 20px;
        }

        .order-card .text-end {
            text-align: center !important;
        }

        .track-line {
            margin: 10px 0;
        }

        .breadcrumb-banner {
            justify-content: center !important;
            text-align: center;
        }
    }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    .table thead th {
        background: #fdfdfd;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>My Orders</h1>
                <nav class="d-flex align-items-center">
                    <a style="text-decoration: none;" href="{{ route('trend-era-home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a style="text-decoration: none;" href="{{ route('order.history') }}">Order History</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="mb-4 fw-bold text-dark">Recent Orders</h3>

            @forelse($orders as $order)
            <div class="order-card p-4 mb-4 shadow-sm border-0">
                <div class="row align-items-center">
                    <div class="col-md-3 col-sm-12">
                        <h6 class="text-muted small mb-1">ORDER ID</h6>
                        <p class="fw-bold mb-0 text-dark" style="font-size: 17px;">#{{ $order->order_number }}</p>
                        <span class="small text-muted"><i class="fa fa-calendar-o mr-1"></i> {{ $order->created_at->format('d M, Y') }}</span>
                    </div>

                    <div class="col-md-5 col-sm-12 py-2">
                        @php
                        $statuses = ['Pending', 'Confirmed', 'Processing', 'Out for Delivery', 'Delivered'];
                        $currentStatusIndex = array_search($order->order_status, $statuses);

                        $statusIcons = [
                        'Pending' => 'fa-clock',
                        'Confirmed' => 'fa-check-double',
                        'Processing' => 'fa-box-open',
                        'Out for Delivery' => 'fa-truck',
                        'Delivered' => 'fa-clipboard-check'
                        ];

                        if ($order->order_status == 'Cancelled' || $order->order_status == 'Returned') {
                        $progressPercent = 0;
                        } else {
                        $progressPercent = ($currentStatusIndex !== false) ? ($currentStatusIndex * 25) : 0;
                        }
                        @endphp

                        <div class="order-tracking-container">
                            <div class="tracking-line-container">
                                <div class="tracking-line-fill" style="width: {{ $progressPercent }}%;"></div>
                            </div>
                            @foreach($statuses as $index => $statusName)
                            @php
                            $isCompleted = ($currentStatusIndex !== false && $index <= $currentStatusIndex);
                                $isActive=($currentStatusIndex !==false && $index==$currentStatusIndex);
                                $icon=$statusIcons[$statusName] ?? 'fa-dot-circle' ;
                                @endphp
                                <div class="tracking-step {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                <div class="tracking-icon">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div class="tracking-label">{{ $statusName == 'Out for Delivery' ? 'Shipping' : $statusName }}</div>
                        </div>
                        @endforeach
                    </div>

                    @if($order->order_status == 'Cancelled')
                    <div class="mt-2 text-center">
                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                            <i class="fas fa-times-circle me-1"></i> Order Cancelled
                        </span>
                    </div>
                    @elseif($order->order_status == 'Returned')
                    <div class="mt-2 text-center">
                        <span class="badge bg-secondary rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                            <i class="fas fa-undo-alt me-1"></i> Order Returned
                        </span>
                    </div>
                    @endif
                </div>

                <div class="col-md-2 d-none d-md-block text-center">
                    <h6 class="text-muted small mb-1">AMOUNT & PAYMENT</h6>
                    <p class="fw-bold text-dark mb-1" style="font-size: 16px;">₹{{ number_format($order->total_amount, 2) }}</p>

                    <div class="small text-uppercase fw-bold text-muted" style="font-size: 10px;">
                        <i class="fa fa-credit-card mr-1"></i>
                        {{ $order->payment_method == 'cod' ? 'Cash On Delivery' : $order->payment_method }}
                    </div>

                    <span class="payment-badge pay-{{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>

                <div class="col-md-2 col-sm-6 text-end mob-text-center">
                    <span class="status-badge status-{{ strtolower($order->order_status) }} mb-2">
                        {{ $order->order_status }}
                    </span>
                    <div class="d-flex justify-content-md-end justify-content-center align-items-center mt-2">
                        @if($order->order_status == 'Delivered')
                        @php
                        $invoiceItemsArr = [];
                        foreach($order->items as $invItem) {
                        $invoiceItemsArr[] = [
                        'name' => $invItem->name,
                        'price' => number_format($invItem->price, 2),
                        'qty' => $invItem->qty,
                        'status' => $invItem->status,
                        'total' => number_format($invItem->price * $invItem->qty, 2),
                        'image' => asset('storage/'.$invItem->image),
                        ];
                        }
                        $invSellTotal = 0;
                        foreach($order->items as $i) $invSellTotal += ($i->price * $i->qty);
                        $invPtDisc = $order->redeemed_details ? $order->redeemed_details->points : 0;
                        $invCoupon = $order->coupon_discount ?? 0;
                        $invDelivery = ($order->total_amount + $invPtDisc + $invCoupon) - $invSellTotal;
                        $invoiceData = [
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer_name.' '.$order->customer_last_name,
                        'customer_phone' => $order->customer_phone,
                        'address' => $order->address.', '.$order->city.' - '.$order->zip_code,
                        'payment_method' => $order->payment_method == 'cod' ? 'Cash On Delivery' : strtoupper($order->payment_method),
                        'payment_status' => ucfirst($order->payment_status),
                        'subtotal' => number_format($invSellTotal, 2),
                        'coupon_code' => $order->coupon_code,
                        'coupon_discount' => $order->coupon_discount ? number_format($order->coupon_discount, 2) : null,
                        'redeemed_pts' => $invPtDisc ? number_format($invPtDisc, 2) : null,
                        'delivery_fee' => $invDelivery > 0 ? number_format($invDelivery, 2) : null,
                        'total_amount' => number_format($order->total_amount, 2),
                        'items' => $invoiceItemsArr,
                        ];
                        @endphp
                        <button onclick="downloadInvoice({{ json_encode($invoiceData) }})" class="btn btn-outline-success btn-sm fw-bold px-2 me-2" style="border-radius: 20px; font-size:12px;" title="Download Invoice">
                            <i class="fas fa-file-pdf me-1"></i> Invoice
                        </button>
                        @endif
                        <a href="javascript:void(0)"
                            data-bs-toggle="modal"
                            data-bs-target="#orderModal{{$order->id}}"
                            class="btn btn-outline-warning btn-sm fw-bold px-3" style="border-radius: 20px;">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Modal -->
        <div class="modal fade" id="orderModal{{$order->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                    <div class="modal-header px-4">
                        <h5 class="modal-title fw-bold">Order Details For #{{$order->order_number}}</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="invoice-content-{{$order->id}}">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <p class="text-muted small mb-1 text-uppercase fw-bold">Customer Info</p>
                                <p class="mb-0 fw-bold text-dark">{{$order->customer_name}} {{$order->customer_last_name}}</p>
                                <p class="mb-0 text-muted">{{$order->customer_phone}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="text-muted small mb-1 text-uppercase fw-bold">Shipping Address</p>
                                <p class="mb-0 text-dark">{{$order->address}}, {{$order->city}} - {{$order->zip_code}}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="text-muted small mb-1 text-uppercase fw-bold">Payment Info</p>
                                <p class="mb-0 text-dark">
                                    <b class="fw-bold text-dark">Method:</b> {{ $order->payment_method == 'cod' ? 'Cash On Delivery' : strtoupper($order->payment_method) }}<br>

                                    <b class="fw-bold text-dark">Status:</b>
                                    @php
                                    $paymentColors = [
                                    'pending' => ['class' => 'text-info', 'icon' => '⏳'],
                                    'paid' => ['class' => 'text-success', 'icon' => '💳'],
                                    'failed' => ['class' => 'text-danger', 'icon' => '❌'],
                                    'Unpaid' => ['class' => 'text-warning', 'icon' => '⚠️'],
                                    'Refunded' => ['class' => 'text-primary', 'icon' => '🔄'],
                                    ];

                                    $currentStatus = $order->payment_status;
                                    $colorClass = $paymentColors[$currentStatus]['class'] ?? 'text-secondary';
                                    $icon = $paymentColors[$currentStatus]['icon'] ?? '💰';
                                    @endphp
                                    <span class="{{ $colorClass }} fw-bold">
                                        {{ $icon }} {{ ucfirst($currentStatus) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr>
                                        <th class="ps-0">Product</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center action-column">Action</th>
                                        <th class="text-end pe-0">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="border-bottom-sm">
                                        <td class="ps-0 fw-bold text-dark">{{$item->name}}</td>
                                        <td class="text-center">
                                            <img src="{{asset('storage/'.$item->image)}}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: contain; background: #f9f9f9;">
                                        </td>
                                        <td class="text-center">₹{{number_format($item->price, 2)}}</td>
                                        <td class="text-center">{{$item->qty}}</td>
                                        <td class="text-center small">
                                            <span class="badge {{ $item->status == 'Cancelled' ? 'bg-danger' : ($item->status == 'Delivered' ? 'bg-success' : 'bg-info') }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="text-center action-column">
                                            @if(!in_array($order->order_status, ['Out for Delivery', 'Delivered', 'Cancelled', 'Returned']) && !in_array($item->status, ['Cancelled', 'Returned']))
                                            <button onclick="changeItemStatus({{ $item->id }}, 'Cancelled')" class="btn btn-sm btn-outline-danger">Cancel</button>
                                            @elseif($order->order_status == 'Delivered' && !in_array($item->status, ['Returned', 'Cancelled']))
                                            <button onclick="changeItemStatus({{ $item->id }}, 'Returned')" class="btn btn-sm btn-outline-secondary">Return</button>
                                            @endif
                                        </td>
                                        <td class="text-end pe-0 fw-bold">₹{{number_format($item->price * $item->qty, 2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                @php
                                $totalSellingPrice = 0;
                                foreach($order->items as $i) 
                                  {
                                         $totalSellingPrice += ($i->price * $i->qty);
                                  }
                                $pointsDiscount = $order->redeemed_details ? $order->redeemed_details->points : 0;
                                $couponDiscount = $order->coupon_discount ?? 0;

                                $computedSubtotal = $order->total_amount + $pointsDiscount + $couponDiscount;
                                $totalDeliveryCharge = $computedSubtotal - $totalSellingPrice;
                                @endphp
                                <span class="fw-bold">₹{{ number_format($totalSellingPrice, 2) }}</span>
                            </div>

                            @if($order->coupon_code)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Coupon Applied (<b class="text-dark">{{ $order->coupon_code }}</b>)
                                </span>
                                <span class="text-success fw-bold">- ₹{{ number_format($order->coupon_discount, 2) }}</span>
                            </div>
                            @endif

                            @if($order->redeemed_details)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    <i class="fa fa-gift text-success mr-1"></i>
                                    Points Redeemed ({{ $order->redeemed_details->points }} pts)
                                </span>
                                <span class="text-success fw-bold">- ₹{{ number_format($order->redeemed_details->points, 2) }}</span>
                            </div>
                            @endif

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Delivery Fee</span>
                                @if($totalDeliveryCharge > 0)
                                <span class="text-success fw-bold">+ ₹{{ number_format($totalDeliveryCharge, 2) }}</span>
                                @else
                                <span class="text-success fw-bold">Free</span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                <h5 class="fw-bold mb-0">Order Amount</h5>
                                <h5 class="fw-bold text-dark mb-0">₹{{ number_format($order->total_amount, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <div class="mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="120" style="filter: grayscale(1) opacity(0.3);">
            </div>
            <h4 class="fw-bold text-muted">No orders found yet!</h4>
            <p class="text-muted">Looks like you haven't placed any orders yet. Start exploring our collection!</p>
            <a href="{{ route('trend-era-shop') }}" class="primary-btn mt-3 border-0 py-2 px-5 rounded-pill shadow-sm" style="background:#ffba00; color:#fff; text-decoration:none;">Shop Now</a>
        </div>
        @endforelse

    </div>
</div>
</div>
<style>
    /* નવા ઓર્ડર સ્ટેટસ કલર્સ */
    .status-confirmed {
        background: #e7f3ff;
        color: #0d6efd;
    }

    /* Blue */
    .status-out-for-delivery {
        background: #fff9e1;
        color: #ffc107;
    }

    /* Yellow/Warning */
    .status-cancelled {
        background: #ffebee;
        color: #dc3545;
    }

    /* Red */
    .status-returned {
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    /* Grey */
    /* Payment Status Badges */
    .payment-badge {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        display: inline-block;
        margin-top: 5px;
    }

    .pay-pending {
        background: #fff4e5;
        color: #ff9800;
        border: 1px solid #ffe5d0;
    }

    .pay-paid {
        background: #e8f5e9;
        color: #4caf50;
        border: 1px solid #c8e6c9;
    }

    .pay-failed {
        background: #ffebee;
        color: #f44336;
        border: 1px solid #ffcdd2;
    }
</style>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function downloadInvoice(data) {

        var payColor = '#555';
        var ps = (data.payment_status || '').toLowerCase();
        if (ps === 'paid') payColor = '#4caf50';
        else if (ps === 'refunded') payColor = '#1976d2';
        else if (ps === 'pending') payColor = '#ff9800';
        else if (ps === 'failed') payColor = '#f44336';

        var itemRows = '';
        data.items.forEach(function(item) {
            var stBg = '#17a2b8';
            if (item.status === 'Cancelled') stBg = '#dc3545';
            else if (item.status === 'Delivered') stBg = '#28a745';
            else if (item.status === 'Returned') stBg = '#6c757d';

            itemRows += `
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px 8px; font-weight:600; font-size:13px;">${item.name}</td>
                <td style="padding: 12px 8px; text-align:center;"><img src="${item.image}" style="width:45px;height:45px;object-fit:contain;background:#f9f9f9;border-radius:4px;"></td>
                <td style="padding: 12px 8px; text-align:center; font-size:13px;">&#8377;${item.price}</td>
                <td style="padding: 12px 8px; text-align:center; font-size:13px;">${item.qty}</td>
                <td style="padding: 12px 8px; text-align:center;"><span style="background:${stBg}; color:#fff; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:700;">${item.status}</span></td>
                <td style="padding: 12px 8px; text-align:right; font-weight:700; font-size:13px;">&#8377;${item.total}</td>
            </tr>`;
        });

        var summaryRows = `
        <tr>
            <td colspan="2" style="padding: 8px 4px; color:#888;">Subtotal</td>
            <td style="padding: 8px 4px; text-align:right; font-weight:600;">&#8377;${data.subtotal}</td>
        </tr>`;
        if (data.coupon_code && data.coupon_discount) {
            summaryRows += `
            <tr>
                <td colspan="2" style="padding: 8px 4px; color:#888;">Coupon Applied (<strong>${data.coupon_code}</strong>)</td>
                <td style="padding: 8px 4px; text-align:right; color:#4caf50; font-weight:600;">- &#8377;${data.coupon_discount}</td>
            </tr>`;
        }
        if (data.redeemed_pts) {
            summaryRows += `
            <tr>
                <td colspan="2" style="padding: 8px 4px; color:#888;">Points Redeemed</td>
                <td style="padding: 8px 4px; text-align:right; color:#4caf50; font-weight:600;">- &#8377;${data.redeemed_pts}</td>
            </tr>`;
        }
        if (data.delivery_fee) {
            summaryRows += `
            <tr>
                <td colspan="2" style="padding: 8px 4px; color:#888;">Delivery Fee</td>
                <td style="padding: 8px 4px; text-align:right; color:#4caf50; font-weight:600;">+ &#8377;${data.delivery_fee}</td>
            </tr>`;
        } else {
            summaryRows += `
            <tr>
                <td colspan="2" style="padding: 8px 4px; color:#888;">Delivery Fee</td>
                <td style="padding: 8px 4px; text-align:right; color:#4caf50; font-weight:600;">Free</td>
            </tr>`;
        }
        summaryRows += `
        <tr style="border-top: 2px solid #333;">
            <td colspan="2" style="padding: 12px 4px; font-weight:700; font-size:16px;">Order Amount</td>
            <td style="padding: 12px 4px; text-align:right; font-weight:700; font-size:16px;">&#8377;${data.total_amount}</td>
        </tr>`;

        var html = `
        <div style="font-family: 'Segoe UI', Arial, sans-serif; background:#fff; padding:40px; width:780px; color:#333;">

            <!-- Header -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="font-size:24px; font-weight:800; margin:0; color:#222;">TAX INVOICE</h2>
                <span style="font-size:14px; color:#666;">#${data.order_number}</span>
            </div>
            <hr style="border:none; border-top:1px solid #ddd; margin-bottom:25px;">

            <!-- Info Row -->
            <div style="display:flex; gap:20px; margin-bottom:25px;">
                <!-- Customer Info -->
                <div style="flex:1; padding-right:15px;">
                    <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#888; letter-spacing:0.5px; margin:0 0 6px;">Customer Info</p>
                    <p style="font-weight:700; font-size:14px; margin:0 0 4px; color:#222;">${data.customer_name}</p>
                    <p style="font-size:13px; color:#666; margin:0;">${data.customer_phone}</p>
                </div>
                <!-- Shipping Address -->
                <div style="flex:1; padding-right:15px;">
                    <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#888; letter-spacing:0.5px; margin:0 0 6px;">Shipping Address</p>
                    <p style="font-size:13px; color:#333; margin:0;">${data.address}</p>
                </div>
                <!-- Payment Info -->
                <div style="flex:1;">
                    <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#888; letter-spacing:0.5px; margin:0 0 6px;">Payment Info</p>
                    <p style="font-size:13px; margin:0 0 4px;"><strong>Method:</strong> ${data.payment_method}</p>
                    <p style="font-size:13px; margin:0;"><strong>Status:</strong> <span style="color:${payColor}; font-weight:700;">${data.payment_status}</span></p>
                </div>
            </div>

            <!-- Items Table -->
            <table style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:20px;">
                <thead>
                    <tr style="border-bottom:2px solid #ddd;">
                        <th style="padding:10px 8px; text-align:left; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:35%;">Product</th>
                        <th style="padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:10%;">Image</th>
                        <th style="padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:14%;">Price</th>
                        <th style="padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:8%;">Qty</th>
                        <th style="padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:13%;">Status</th>
                        <th style="padding:10px 8px; text-align:right; font-size:11px; text-transform:uppercase; color:#666; font-weight:700; width:14%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemRows}
                </tbody>
            </table>

            <!-- Summary Box -->
            <div style="background:#f8f9fa; border-radius:8px; padding:20px; margin-top:10px;">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    ${summaryRows}
                </table>
            </div>

        </div>`;

        var opt = {
            margin: 0,
            filename: 'Invoice-' + data.order_number + '.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                logging: false
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(html).save().then(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: 'Invoice downloaded successfully'
            });
        });
    }

    function changeItemStatus(itemId, status) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to " + status + " this item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/order-item/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: itemId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Updated!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    });
            }
        })
    }
</script>
@endpush