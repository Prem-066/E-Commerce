<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2c2c2c;
            background: #ffffff;
        }

        /* ════ WATERMARK ════ */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -60%);
            z-index: 0;
            opacity: 0.20;
            width: 500px;
            height: 500px;
        }

        .watermark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: grayscale(100%);
        }

        .page-wrap {
            position: relative;
            z-index: 1;
        }

        /* ════ TOP STRIPS ════ */
        .strip-gold {
            background: #c8a951;
            height: 4px;
        }

        .strip-dark {
            background: #0f172a;
            height: 7px;
        }

        /* ════ HEADER ════ */
        .invoice-header {
            background: #0f172a;
            padding: 24px 35px 20px;
        }

        .header-row {
            display: table;
            width: 100%;
        }

        .header-left,
        .header-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            text-align: right;
        }

        .brand-logo {
            height: 52px;
            width: auto;
            object-fit: contain;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .brand-tagline {
            font-size: 8px;
            color: #c8a951;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .inv-badge {
            display: inline-block;
            background: #c8a951;
            color: #0f172a;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 4px 16px;
            border-radius: 2px;
            margin-bottom: 8px;
        }

        .inv-number {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }

        .inv-date {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 4px;
        }

        /* ════ INFO ROW ════ */
        .info-section {
            background: #f8f6f0;
            padding: 20px 35px;
            border-bottom: 1px solid #e8e2d5;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding-right: 25px;
        }

        .info-col:last-child {
            padding-right: 0;
        }

        .info-label {
            font-size: 7.5px;
            font-weight: 700;
            color: #c8a951;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1.5px solid #c8a951;
        }

        .info-value {
            font-size: 11.5px;
            color: #444;
            line-height: 1.75;
            margin-top: 4px;
        }

        .info-value strong {
            color: #0f172a;
            font-weight: 700;
        }

        .pay-pill {
            display: inline-block;
            padding: 2px 11px;
            border-radius: 20px;
            font-size: 9.5px;
            font-weight: 700;
        }

        .pay-pending {
            background: #fff3e0;
            color: #e65100;
        }

        .pay-paid {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .pay-failed {
            background: #ffebee;
            color: #b71c1c;
        }

        .pay-unpaid {
            background: #fff8e1;
            color: #f57f17;
        }

        .pay-refunded {
            background: #e3f2fd;
            color: #1565c0;
        }

        /* ════ ITEMS TABLE ════ */
        .items-section {
            padding: 24px 35px 12px;
        }

        .section-heading {
            font-size: 9px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }

        .heading-line {
            border-bottom: 2px solid #c8a951;
            padding-bottom: 4px;
            padding-right: 12px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #0f172a;
        }

        thead th {
            padding: 11px 13px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #c8a951;
            text-align: left;
        }

        thead th.tc {
            text-align: center;
        }

        thead th.tr {
            text-align: right;
        }

        tbody tr {
            border-bottom: 1px solid #f0ede6;
        }

        /* tbody tr:nth-child(even) {
            background: #fdfcfa;
        } */

        tbody tr:last-child {
            border-bottom: 2px solid #e8e2d5;
        }

        tbody td {
            padding: 11px 13px;
            font-size: 11.5px;
            color: #444;
            vertical-align: middle;
        }

        td.tc {
            text-align: center;
        }

        td.tr {
            text-align: right;
        }

        td.sr {
            color: #bbb;
            font-size: 10.5px;
        }

        td.pname {
            font-weight: 700;
            color: #0f172a;
        }

        td.ptotal {
            font-weight: 700;
            color: #0f172a;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-delivered {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-cancelled {
            background: #ffebee;
            color: #b71c1c;
        }

        .badge-default {
            background: #e8eaf6;
            color: #283593;
        }

        /* ════ BOTTOM: NOTE + SUMMARY ════ */
        .bottom-section {
            display: table;
            width: 100%;
            padding: 16px 35px 28px;
        }

        .note-col,
        .summary-col {
            display: table-cell;
            vertical-align: top;
        }

        .note-col {
            width: 50%;
            padding-right: 20px;
        }

        .summary-col {
            width: 50%;
        }

        .note-box {
            background: #f8f6f0;
            border-left: 3px solid #c8a951;
            border-radius: 4px;
            padding: 14px 16px;
        }

        .note-title {
            font-size: 9px;
            font-weight: 700;
            color: #c8a951;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 7px;
        }

        .note-text {
            font-size: 11px;
            color: #777;
            line-height: 1.7;
        }

        .note-text strong {
            color: #0f172a;
        }

        .summary-box {
            background: #0f172a;
            border-radius: 6px;
            padding: 18px 22px;
        }

        .summary-box-title {
            font-size: 8px;
            font-weight: 700;
            color: #c8a951;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-bottom: 10px;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(200, 169, 81, 0.25);
        }

        .srow {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .srow:last-child {
            margin-bottom: 0;
        }

        .slabel,
        .sval {
            display: table-cell;
            vertical-align: middle;
        }

        .slabel {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
        }

        .sval {
            text-align: right;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
        }

        .sval-green {
            color: #69f0ae;
        }

        .sval-red {
            color: #ff6e6e;
        }

        .sdivider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 11px 0;
        }

        .srow-total .slabel {
            font-size: 13px;
            font-weight: 700;
            color: #c8a951;
        }

        .srow-total .sval {
            font-size: 15px;
            font-weight: 700;
            color: #c8a951;
        }

        /* ════ FOOTER ════ */
        .footer-bar {
            background: #f8f6f0;
            border-top: 1px solid #e8e2d5;
            padding: 12px 35px;
            display: table;
            width: 100%;
        }

        .footer-left,
        .footer-right {
            display: table-cell;
            vertical-align: middle;
        }

        .footer-right {
            text-align: right;
        }

        .footer-left {
            font-size: 9.5px;
            color: #aaa;
        }

        .footer-right {
            font-size: 9.5px;
            color: #aaa;
        }

        .footer-brand {
            color: #c8a951;
            font-weight: 700;
        }

        .strip-bottom-gold {
            background: #c8a951;
            height: 3px;
        }

        .strip-bottom-dark {
            background: #0f172a;
            height: 6px;
        }
    </style>
</head>

<body>

    {{-- WATERMARK --}}
    @if(!empty($setting) && !empty($setting->logo))
    <div class="watermark">
        <img src="{{ public_path('storage/' . $setting->logo) }}">
    </div>
    @endif

    <div class="page-wrap">

        <div class="strip-gold"></div>
        <div class="strip-dark"></div>

        {{-- HEADER --}}
        <div class="invoice-header">
            <div class="header-row">
                <div class="header-left">
                    @if(!empty($setting) && !empty($setting->logo))
                    <img src="{{ public_path('storage/' . $setting->logo) }}" class="brand-logo" alt="Logo">
                    @else
                    <div class="brand-name">{{ $setting->site_name ?? 'TREND ERA' }}</div>
                    @endif
                    <div class="brand-tagline">TREND ERA</div>
                </div>
                <div class="header-right">
                    <div class="inv-badge">Tax Invoice</div><br>
                    <div class="inv-number"># {{ $order->order_number }}</div>
                    <div class="inv-date">Issued: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="info-section">
            <div class="info-grid">

                <div class="info-col">
                    <div class="info-label">Bill To</div>
                    <div class="info-value">
                        <strong>{{ $order->customer_name }} {{ $order->customer_last_name }}</strong><br>
                        {{ $order->customer_phone }}
                    </div>
                </div>

                <div class="info-col">
                    <div class="info-label">Ship To</div>
                    <div class="info-value">
                        {{ $order->address }},<br>
                        {{ $order->city }} - {{ $order->zip_code }}
                    </div>
                </div>

                <div class="info-col">
                    @php $payStatus = strtolower($order->payment_status); @endphp
                    <div class="info-label">Payment</div>
                    <div class="info-value">
                        <strong>{{ $order->payment_method == 'cod' ? 'Cash On Delivery' : strtoupper($order->payment_method) }}</strong><br>
                        <span class="pay-pill pay-{{ $payStatus }}">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ITEMS --}}
        <div class="items-section">
            <div class="section-heading"><span class="heading-line">Order Items</span></div>
            <table>
                <thead>
                    <tr>
                        <th style="width:4%">#</th>
                        <th style="width:40%">Product Description</th>
                        <th class="tc" style="width:14%">Unit Price</th>
                        <th class="tc" style="width:8%">Qty</th>
                        <th class="tc" style="width:16%">Status</th>
                        <th class="tr" style="width:18%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalSellingPrice = 0; @endphp
                    @foreach($order->items as $item)
                    @php $totalSellingPrice += ($item->price * $item->qty); @endphp
                    <tr>
                        <td class="sr">{{ $loop->iteration }}</td>
                        <td class="pname">{{ $item->name }}</td>
                        <td class="tc">Rs. {{ number_format($item->price, 2) }}</td>
                        <td class="tc"><strong>{{ $item->qty }}</strong></td>
                        <td class="tc">
                            @php
                            $bc = match($item->status) {
                            'Delivered' => 'badge-delivered',
                            'Cancelled' => 'badge-cancelled',
                            default => 'badge-default',
                            };
                            @endphp
                            <span class="status-badge {{ $bc }}">{{ $item->status }}</span>
                        </td>
                        <td class="tr ptotal">Rs. {{ number_format($item->price * $item->qty, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- BOTTOM --}}
        @php
        $pointsDiscount = $order->redeemed_details->points ?? 0;
        $couponDiscount = $order->coupon_discount ?? 0;
        $computedSubtotal = $order->total_amount + $pointsDiscount + $couponDiscount;
        $totalDeliveryCharge = $computedSubtotal - $totalSellingPrice;
        @endphp

        <div class="bottom-section">

            <div class="note-col">
                <div class="note-box">
                    <div class="note-title">Thank You!</div>
                    <div class="note-text">
                        We appreciate your trust in
                        <strong>{{ $setting->site_name ?? 'Trend Era' }}</strong>.
                        Your order has been processed successfully.<br><br>
                        For any queries, please contact our support team.
                        We hope to see you again soon!
                    </div>
                </div>
            </div>

            <div class="summary-col">
                <div class="summary-box">
                    <div class="summary-box-title">Order Summary</div>

                    <div class="srow">
                        <div class="slabel">Subtotal</div>
                        <div class="sval">Rs. {{ number_format($totalSellingPrice, 2) }}</div>
                    </div>

                    @if($order->coupon_code)
                    <div class="srow">
                        <div class="slabel">Coupon - {{ $order->coupon_code }}</div>
                        <div class="sval sval-green">- Rs. {{ number_format($order->coupon_discount, 2) }}</div>
                    </div>
                    @endif

                    @if(!empty($order->redeemed_details) && $order->redeemed_details->points > 0)
                    <div class="srow">
                        <div class="slabel">Points ({{ $order->redeemed_details->points }} pts)</div>
                        <div class="sval sval-green">- Rs. {{ number_format($order->redeemed_details->points, 2) }}</div>
                    </div>
                    @endif

                    <div class="srow">
                        <div class="slabel">Delivery Fee</div>
                        @if($totalDeliveryCharge > 0)
                        <div class="sval sval-red">+ Rs. {{ number_format($totalDeliveryCharge, 2) }}</div>
                        @else
                        <div class="sval sval-green">Free</div>
                        @endif
                    </div>

                    <hr class="sdivider">

                    <div class="srow srow-total">
                        <div class="slabel">Total Amount</div>
                        <div class="sval">Rs. {{ number_format($order->total_amount, 2) }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="footer-bar">
            <div class="footer-left">
                <span class="footer-brand">{{ $setting->site_name ?? 'Trend Era' }}</span>
                &nbsp;-&nbsp; {{ $setting->site_tagline ?? 'Your Fashion Destination' }}
            </div>
            <div class="footer-right">
                Computer generated invoice &bull; No signature required
            </div>
        </div>
        <div class="strip-bottom-gold"></div>
        <div class="strip-bottom-dark"></div>

    </div>
</body>
</html>