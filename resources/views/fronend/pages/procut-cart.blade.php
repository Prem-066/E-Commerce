@extends('fronend.partials.app')
@section('title', 'Shopping Cart')
@section('contentt')

<section class="banner-area organic-breadcrumb mb-0">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('trend-era-home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('cart.show') }}">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="cart_area bg-light py-5">
    <div class="container">
        <h3 class="fw-bold mb-4" style="color: #222;">Shopping Cart ({{ $allCartItems->count() }} items)</h3>

        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #fff5f5; color: #c53030;">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($stockErrors)
                <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #fffaf0; color: #975a16;">
                    <i class="fas fa-exclamation-triangle me-2"></i> Some items in your cart have insufficient stock. Please update quantities to proceed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($allCartItems->count() > 0)
                @php
                $totalOriginalPrice = 0;
                $totalSellingPrice = 0;
                $totalDeliveryCharge = 0;
                @endphp
                @foreach($allCartItems as $item)
                @php
                $sellingPrice = $item->product->price;
                $originalPrice = ($item->product->discount_price > $sellingPrice) ? $item->product->discount_price : ($sellingPrice / 0.6);

                $itemDeliveryCharge = $item->product->delivery_charge ?? 0;
                $itemSubtotal = ($sellingPrice * $item->quantity) + $itemDeliveryCharge;

                $itemOriginalSubtotal = $originalPrice * $item->quantity;

                $totalSellingPrice += ($sellingPrice * $item->quantity);
                $totalOriginalPrice += $itemOriginalSubtotal;
                $totalDeliveryCharge += $itemDeliveryCharge;
                @endphp

                <div class="cart-item-card bg-white p-3 mb-3 shadow-sm" style="border-radius: 15px; border: 1px solid #eff0f5;">
                    <div class="row align-items-center g-0">
                        <!-- Product Image Area -->
                        <div class="col-3 col-md-2">
                            <div class="image-container p-2" style="background: #f7f7f7; border-radius: 12px; height: 110px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="img-fluid" style="max-height: 90px; border-radius: 5px;" alt="{{ $item->product->name }}">
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-9 col-md-10 ps-3">
                            <div class="d-flex flex-column h-100">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <a href="{{ route('product-detail', $item->product->slug) }}" class="text-decoration-none">
                                            <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;">{{ $item->product->name }}</h5>
                                        </a>

                                        @if($item->product->stock < $item->quantity)
                                            <div class="stock-warning mb-2">
                                                @if($item->product->stock <= 0)
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                    @else
                                                    <span class="badge bg-warning text-dark">Only {{ $item->product->stock }} units left</span>
                                                    @endif
                                            </div>
                                            @endif

                                            <p class="text-muted small mb-2">{{ $item->product->brand->name ?? 'TrendEra Collection' }}</p>

                                            @php
                                            $discountPercent = round((($originalPrice - $sellingPrice) / $originalPrice) * 100);
                                            @endphp
                                            <div class="price-box d-flex align-items-center flex-wrap gap-2 mb-2">
                                                <span class="fw-bold" style="font-size: 1.3rem; color: #222;">₹{{ number_format($sellingPrice) }}</span>
                                                <span class="text-muted text-decoration-line-through" style="font-size: 0.95rem;">MRP: ₹{{ number_format($originalPrice) }}</span>
                                                @if($discountPercent > 0)
                                                <span class="badge" style="background-color: #e6f4ea; color: #1e8e3e; font-size: 0.8rem; padding: 4px 8px;">{{ $discountPercent }}% OFF</span>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="text-end d-none d-md-block">
                                        <div class="text-muted text-decoration-line-through small mb-1" style="font-size: 13px;">MRP: ₹<span id="item-orig-subtotal-{{ $item->id }}" data-orig-price="{{ $originalPrice }}">{{ number_format($itemOriginalSubtotal) }}</span></div>
                                        <h5 class="fw-bold mb-0" style="color: #ff6f00;">₹<span id="item-subtotal-{{ $item->id }}">{{ number_format($sellingPrice) }}</span></h5>
                                    </div>
                                </div>
                                <!-- Actions Row -->
                                <div class="d-flex align-items-center gap-4 mt-2">
                                    <div class="qty-picker d-flex align-items-center border" style="border-radius: 8px; background: #fff; height: 32px;">
                                        <button onclick="changeQty('{{ $item->id }}', -1)" class="btn btn-sm px-2 border-0" style="color: #666; font-weight: bold;">-</button>

                                        <input type="number"
                                            id="qty-{{ $item->id }}"
                                            value="{{ $item->quantity }}"
                                            onchange="manualUpdate('{{ $item->id }}', this.value)"
                                            class="text-center border-0 fw-bold"
                                            style="width: 45px; font-size: 14px; background: transparent; outline: none;"
                                            min="1">

                                        <button id="plus-btn-{{ $item->id }}"
                                            onclick="changeQty('{{ $item->id }}', 1)"
                                            class="btn btn-sm px-2 border-0"
                                            style="color: #666; font-weight: bold; {{ $item->product->stock > $item->quantity ? '' : 'display:none;' }}">+</button>
                                    </div>

                                    <button onclick="removeFromCart('{{ $item->id }}')" class="btn btn-link link-secondary text-decoration-none p-0 small fw-bold" style="font-size: 13px;">
                                        <i class="fas fa-trash-alt me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Trust Indicators Ribbon -->
                <div class="trust-indicators bg-white py-3 px-4 shadow-sm mb-4 d-flex justify-content-between align-items-center text-center mt-4" style="border-radius: 12px; border: 1px solid #eee;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-shield-alt text-muted fs-5"></i>
                        <span class="small text-muted fw-bold">Secure Payment</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-shipping-fast text-muted fs-5"></i>
                        <span class="small text-muted fw-bold">Free Delivery</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-undo-alt text-muted fs-5"></i>
                        <span class="small text-muted fw-bold">Easy Returns</span>
                    </div>
                </div>
                @else
                <div class="empty-cart text-center py-5 bg-white border" style="border-radius: 20px;">
                    <i class="fas fa-shopping-basket text-muted mb-3" style="font-size: 5rem; opacity: 0.2;"></i>
                    <h4 class="fw-bold">Your cart feels lonely!</h4>
                    <p class="text-muted">Explore our latest arrivals and fill it with style.</p>
                    <a href="{{ route('trend-era-shop') }}" class="primary-btn mt-3" style="text-decoration: none; border-radius: 10px;">Return to Shop</a>
                </div>
                @endif
            </div>

            <!-- Price Breakdown Sidebar -->
            <div class="col-lg-4">
                @if($allCartItems->count() > 0)
                @php
                $coupon = session('coupon');
                $couponDiscount = $coupon ? $coupon['discount'] : 0;
                $productSellingTotal = $totalSellingPrice;
                $productDiscount = $totalOriginalPrice - $productSellingTotal;
                $totalSavings = $productDiscount + $couponDiscount;
                $finalBill = $productSellingTotal + $totalDeliveryCharge - $couponDiscount;
                @endphp
                <div class="price-summary-card bg-white shadow-sm p-4 sticky-top" style="border-radius: 20px; top: 120px; border: 1px solid #eff0f5;">
                    <h6 class="text-uppercase fw-bold text-muted small letter-spacing-1 mb-4">Price Details</h6>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Grand Price ({{ $allCartItems->count() }} items)</span>
                        <span class="text-dark">₹<span id="total-original-price">{{ number_format($totalOriginalPrice) }}</span></span>
                    </div>


                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Discount</span>
                        <span class="text-success">-₹<span id="product-discount">{{ number_format($productDiscount) }}</span></span>
                    </div>

                    @if($couponDiscount > 0)
                    <div class="d-flex justify-content-between mb-3 pulse-discount">
                        <span class="text-dark">Coupon Discount</span>
                        <span class="text-success">-₹{{ number_format($couponDiscount) }}</span>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-dark">Delivery Fee</span>
                        @if($totalDeliveryCharge == 0)
                        <span class="text-success fw-bold" id="total-delivery-charge-text">FREE</span>
                        @else
                        <span class="text-success fw-bold" id="total-delivery-charge-text">+₹{{ number_format($totalDeliveryCharge) }}</span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-dark fw-bold" style="font-size: 1.05rem; padding-bottom: 10px;">
                        <span>Total Price</span>
                        <span>₹<span id="product-selling-total">{{ number_format($productSellingTotal) }}</span></span>
                    </div>


                    <div class="total-bar border-top border-bottom py-3 mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Grand Total</h5>
                        <h4 class="fw-bold mb-0">₹<span id="final-bill">{{ number_format($finalBill) }}</span></h4>
                    </div>

                    @if($totalSavings > 0)
                    <div class="text-center mb-4">
                        <span class="text-success fw-bold small">
                            <i class="bi bi-magic me-1"></i>You will save ₹{{ number_format($totalSavings) }} on this order
                        </span>
                    </div>
                    @endif

                    <!-- Coupon Block -->
                    <div class="coupon-block mb-4 p-3 border rounded-4" style="background: #f8f9ff; border: 1px dashed #4a6cf7 !important;">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-ticket-alt text-primary me-2"></i>
                            <h6 class="mb-0 fw-bold small">Apply Coupon</h6>
                        </div>

                        @if(!$coupon)
                        <div class="input-group">
                            <input type="text" id="coupon_code" class="form-control border-end-0 bg-white" placeholder="Enter coupon code" style="border-radius: 10px 0 0 10px; font-size: 13px; height: 42px; border: 1px solid #dee2e6;">
                            <button onclick="applyCoupon()" class="btn btn-primary fw-bold" style="border-radius: 0 10px 10px 0; font-size: 13px; padding: 0 20px;">Apply</button>
                        </div>
                        @else
                        <div class="applied-coupon p-2 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block fw-bold text-primary mb-0" style="font-size: 14px;">{{ $coupon['code'] }}</span>
                                <span class="text-muted small" style="font-size: 11px;">{{ $coupon['description'] ?? 'Discount applied' }}</span>
                            </div>
                            <button onclick="removeCoupon()" class="btn btn-link text-danger text-decoration-none fw-bold small p-0">Remove</button>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('checkout') }}" id="checkout-btn" data-has-stock-error="{{ $stockErrors ? 'true' : 'false' }}" onclick="return checkStockBeforeCheckout(event)" class="primary-btn border-0 w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="border-radius: 12px; font-weight: 800; font-size: 16px; text-decoration: none;">
                        Proceed to Checkout <i class="fas fa-long-arrow-alt-right fs-5"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .pulse-discount {
        animation: pulse-green 2s infinite;
        padding: 5px;
        border-radius: 5px;
    }

    @keyframes pulse-green {
        0% {
            background-color: rgba(40, 167, 69, 0);
        }

        50% {
            background-color: rgba(40, 167, 69, 0.05);
        }

        100% {
            background-color: rgba(40, 167, 69, 0);
        }
    }

    .cart-item-card {
        transition: all 0.3s ease;
    }

    .cart-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06) !important;
    }

    .letter-spacing-1 {
        letter-spacing: 1px;
    }

    .primary-btn {
        background: #ff6f00;
        background: linear-gradient(90deg, #ff8c00 0%, #ff5200 100%);
        color: white !important;
        border: none;
    }

    .primary-btn:hover {
        background: linear-gradient(90deg, #ff5200 0%, #ff8c00 100%);
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(255, 111, 0, 0.3) !important;
    }

    .btn-primary {
        background: #4a6cf7;
        border-color: #4a6cf7;
    }

    .btn-primary:hover {
        background: #3b5bdb;
        border-color: #3b5bdb;
    }

    .qty-picker button:hover {
        background: #f0f0f0;
    }

    .header_area {
        z-index: 9999 !important;
    }

    .price-summary-card.sticky-top {
        top: 100px !important;
        z-index: 100 !important;
    }

    @media (max-width: 991px) {
        .price-summary-card.sticky-top {
            position: relative !important;
            top: 0 !important;
        }
    }
</style>

@push('scripts')
<script>
    function applyCoupon() {
        let code = document.getElementById('coupon_code').value;
        if (!code) {
            alert('Please enter a coupon code.');
            return;
        }

        fetch('{{ route("coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    coupon_code: code
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function removeCoupon() {
        fetch('{{ route("coupon.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Could not remove coupon.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateCart(cartId, action) {
        let qtyInput = document.getElementById('qty-' + cartId);
        let currentQty = parseInt(qtyInput.value);

        if (action === 'increase') {
            currentQty++;
        } else if (action === 'reduce' && currentQty > 1) {
            currentQty--;
        } else {
            return;
        }

        fetch('/update-cart-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: currentQty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Something went wrong!');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function removeFromCart(cartId) {
        if (confirm('Are you sure you want to remove this item?')) {
            fetch('/remove-from-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart_id: cartId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Could not remove item.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
<script>
    function changeQty(cartId, change) {
        let input = $('#qty-' + cartId);
        let newQty = parseInt(input.val()) + change;

        if (newQty >= 1) {
            updateCartQuantity(cartId, newQty);
        }
    }

    function manualUpdate(cartId, newQty) {
        if (newQty < 1 || newQty == "") {
            $('#qty-' + cartId).val(1);
            newQty = 1;
        }
        updateCartQuantity(cartId, newQty);
    }

    function updateCartQuantity(cartId, quantity) {
        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cart_id: cartId,
                quantity: quantity
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (response.coupon_removed) {
                        alert('Order total is low, coupon removed!');
                        location.reload();
                        return;
                    }

                    $('#qty-' + cartId).val(response.new_qty);
                    response.has_stock ? $('#plus-btn-' + cartId).show() : $('#plus-btn-' + cartId).hide();
                    $('#item-subtotal-' + cartId).text(response.item_subtotal);
                    $('#total-original-price').text(response.total_original);
                    $('#product-discount').text(response.product_discount);
                    $('#product-selling-total').text(response.product_selling_total);

                    if (response.total_delivery_charge == 0 || response.total_delivery_charge == "0") {
                        $('#total-delivery-charge-text').text("FREE");
                    } else {
                        $('#total-delivery-charge-text').text("+₹" + response.total_delivery_charge);
                    }

                    $('#final-bill').text(response.final_bill);
                    $('#cart-count-badge').text(response.total_cart_count);

                    // Update original subtotal if we have it
                    let origPrice = $('#item-orig-subtotal-' + cartId).data('orig-price');
                    if (origPrice) {
                        let origSubtotal = origPrice * response.new_qty;
                        let formattedOrig = Number(origSubtotal).toLocaleString('en-US');
                        $('#item-orig-subtotal-' + cartId).text(formattedOrig);
                    }
                } else {
                    alert(response.message);
                    if (response.current_qty) $('#qty-' + cartId).val(response.current_qty);
                }
            }
        });
    }

    function checkStockBeforeCheckout(e) {
        e.preventDefault();
        let btn = $(e.currentTarget);

        // Disable button to prevent multiple clicks
        btn.addClass('disabled').css('pointer-events', 'none').css('opacity', '0.7');

        $.ajax({
            url: "{{ route('cart.checkStock') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = "{{ route('checkout') }}";
                } else {
                    alert(response.message);
                    location.reload(); // Reload to show updated stock statuses
                }
            },
            error: function() {
                alert('Something went wrong. Please refresh and try again.');
                btn.removeClass('disabled').css('pointer-events', 'auto').css('opacity', '1');
            }
        });

        return false;
    }
</script>
@endpush
@endsection