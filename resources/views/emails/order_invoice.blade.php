<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - TrendEra</title>
    <style> 
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1a202c;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
            background-color: #f8fafc;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
        }

        /* Header */
        .header {
            background-color: #0f172a;
            padding: 50px 40px;
            text-align: center;
        }

        .logo-img {
            max-width: 180px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .logo-text {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Order Confirmed Status */
        .status-section {
            text-align: center;
            padding: 40px 20px 20px;
            background-color: #ffffff;
        }

        .check-circle {
            width: 56px;
            height: 56px;
            background: #10b981;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .status-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px;
        }

        .status-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        /* Content Area */
        .content {
            padding: 0 40px 40px;
        }

        .divider {
            height: 1px;
            background-color: #f1f5f9;
            margin: 30px 0;
        }

        .greeting {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            text-align: center;
        }

        .intro {
            font-size: 15px;
            color: #64748b;
            margin-bottom: 32px;
            text-align: center;
            line-height: 1.6;
        }

        .stats-table {
            width: 100%;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 32px;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }

        .stat-item {
            padding: 16px;
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: 700;
        }

        /* Product Table with Borders */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-table th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 12px 16px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .product-table tr:last-child td {
            border-bottom: none;
        }

        .product-info p {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }

        .product-info span {
            font-size: 11px;
            color: #94a3b8;
        }

        /* Summary Section */
        .summary-section {
            margin-top: 40px;
        }

        /* Address & Summary Borders */
        .address-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }

        .section-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .payment-table {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            border-collapse: collapse;
        }

        .payment-table td {
            padding: 12px 16px;
            font-size: 14px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }

        .payment-table tr:last-child td {
            border-bottom: none;
        }

        .payment-table .total-row {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .grand-total-label {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .grand-total-value {
            font-size: 18px;
            font-weight: 800;
            color: #ea580c;
        }

        /* Bonus Banner */
        .points-banner {
            background: #f0fdf4;
            border: 1px dashed #4ade80;
            border-radius: 12px;
            padding: 16px;
            margin: 32px 0;
            text-align: center;
            color: #166534;
            font-size: 14px;
            font-weight: 600;
        }

        /* Main CTA */
        .btn-main {
            display: block;
            background: #0f172a;
            color: #ffffff !important;
            text-align: center;
            text-decoration: none;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            margin-top: 32px;
        }

        .payment-method-text {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 16px;
        }

        /* Footer */
        .footer {
            background-color: #f8fafc;
            padding: 48px 40px;
            text-align: center;
        }

        .footer p {
            font-size: 13px;
            color: #94a3b8;
            margin: 4px 0;
        }

        .footer-links {
            margin: 24px 0;
        }

        .footer-links a {
            color: #0f172a;
            text-decoration: none;
            font-weight: 600;
            margin: 0 12px;
            font-size: 13px;
        }

        @media screen and (max-width: 600px) {
            .container {
                border-radius: 0;
            }

            .content {
                padding: 0 20px 30px;
            }

            .side-by-side {
                display: block !important;
            }

            .side-col {
                width: 100% !important;
                margin-bottom: 24px !important;
                display: block !important;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <!-- Brand Header -->
            <div class="header">
                @if($logo && file_exists(storage_path('app/public/' . $logo)))
                <img src="{{ $message->embed(storage_path('app/public/' . $logo)) }}" alt="Store Logo" class="logo-img">
                @else
                <div class="logo-text">TRENDERA</div>
                @endif
            </div>

            <!-- Confirmation Bar -->
            <div class="status-section">
                <div class="check-circle">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h1 class="status-title">Order Confirmed</h1>
                <p class="status-subtitle text-muted">Thank you for shopping with us!</p>
            </div>

            <div class="content">
                <div class="divider"></div>

                <div class="greeting">Hey {{ $order->customer_name }},</div>
                <p class="intro">Your style is on its way! We've received your order and we're getting everything ready for shipping. Here's a look at what you've ordered.</p>

                <!-- Order Info Table with Borders -->
                <table class="stats-table">
                    <tr>
                        <td class="stat-item">
                            <div class="stat-label">Order ID</div>
                            <div class="stat-value">#{{ substr($order->order_number, -8) }}</div>
                        </td>
                        <td class="stat-item">
                            <div class="stat-label">Date</div>
                            <div class="stat-value">{{ $order->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="stat-item">
                            <div class="stat-label">Items</div>
                            <div class="stat-value">{{ count($items) }} Products</div>
                        </td>
                    </tr>
                </table>

                <!-- Product Table with Borders -->
                <table class="product-table">
                    <thead>
                        <tr>
                            <th style="width: 60%">Product Details</th>
                            <th style="text-align: center; width: 15%">Qty</th>
                            <th style="text-align: right; width: 25%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="product-info">
                                <p>{{ $item['name'] }}</p>
                                <span>Premium Quality Guarantee</span>
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #64748b;">{{ $item['qty'] }}</td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">₹{{ number_format($item['price'] * $item['qty'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Shipping & Billing Side-by-Side -->
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="48%" valign="top">
                            <div class="section-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Shipping Address
                            </div>
                            <div class="address-card">
                                <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $order->customer_name }} {{ $order->customer_last_name }}</div>
                                <div style="font-size: 14px; color: #64748b; line-height: 1.5;">
                                    {{ $order->address }}<br>
                                    {{ $order->city }} - {{ $order->pin_code ?? $order->zip_code }}<br>
                                    <span style="font-weight: 600; color: #475569; display: block; margin-top: 8px;">📞 {{ $order->customer_phone }}</span>
                                </div>
                            </div>
                        </td>
                        <td width="4%">&nbsp;</td>
                        <td width="48%" valign="top">
                            <div class="section-label">Order Summary</div>
                            <table class="payment-table">
                                @php
                                $subtotal = 0;
                                foreach($items as $item){
                                $subtotal += ($item['price'] * $item['qty']);
                                }
                                @endphp
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right" style="font-weight: 600; color: #1e293b;">₹{{ number_format($subtotal, 2) }}</td>
                                </tr>
                                @if($order->coupon_discount > 0)
                                <tr>
                                    <td>Coupon Discount</td>
                                    <td align="right" style="color: #ef4444; font-weight: 600;">-₹{{ number_format($order->coupon_discount, 2) }}</td>
                                </tr>
                                @endif
                                @if($pointsUsed > 0)
                                <tr>
                                    <td>Points Applied</td>
                                    <td align="right" style="color: #ef4444; font-weight: 600;">-₹{{ number_format($pointsUsed, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Delivery</td>
                                    <td align="right" style="color: #10b981; font-weight: 700;">FREE</td>
                                </tr>
                                <tr class="total-row">
                                    <td class="grand-total-label">Grand Total</td>
                                    <td align="right" class="grand-total-value">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                @if($pointsEarned > 0)
                <div class="points-banner">
                    ✨ High Five! You just earned <strong>{{ $pointsEarned }}</strong> TrendEra Points!
                </div>
                @endif

                <!-- CTA -->
                <a href="" class="btn-main">Track My Order</a>

                <div class="payment-method-text">
                    Secured payment via <strong>{{ strtoupper($order->payment_method) }}</strong> ({{ ucfirst($order->payment_status) }})
                </div>
            </div>

            <!-- Enhanced Footer -->
            <div class="footer">
                <div class="footer-links">
                    <a href="#">Help Center</a>
                    <a href="#">Returns</a>
                    <a href="#">Privacy</a>
                </div>

                <p>Questions? We're here 24/7 at <a href="mailto:{{ $supportEmail }}" style="color: #ea580c; text-decoration: none; font-weight: 600;">{{ $supportEmail }}</a></p>
                <div style="margin-top: 24px; opacity: 0.5;">
                    <p>&copy; {{ date('Y') }} TrendEra. All rights reserved.</p>
                    <p>F-102, Fashion District, Gujarat, India</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>