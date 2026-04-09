@extends('fronend.partials.app')
@section('title','Checkout - Trend Era')
@section('contentt')

<style>
    :root {
        --primary-color: #ffba00; /* Warm warning/gold from your button */
        --success-color: #28a745;
        --border-radius: 12px;
    }

    .checkout_area {
        background: #f9f9f9;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    /* Card Styling */
    .checkout-card {
        background: #fff;
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: #222;
        border-left: 5px solid var(--primary-color);
        padding-left: 15px;
    }

    /* Address Selection Chips */
    .address-selector {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .address-chip {
        flex: 1;
        min-width: 140px;
        position: relative;
    }

    .address-chip input[type="radio"] {
        display: none;
    }

    .address-chip label {
        display: block;
        padding: 15px;
        text-align: center;
        border: 2px solid #eee;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        margin-bottom: 0;
    }

    .address-chip input[type="radio"]:checked + label {
        border-color: var(--primary-color);
        background: #fffef5;
        color: var(--primary-color);
    }

    /* Payment Box Styling */
    .payment-box {
        cursor: pointer;
        border: 2px solid #eee !important;
        border-radius: var(--border-radius) !important;
        transition: 0.3s;
        position: relative;
        padding: 20px !important;
    }

    .payment-box.active-success {
        border-color: var(--success-color) !important;
        background: #f0fff4 !important;
    }

    /* Form Styling */
    .form-control {
        height: 50px;
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px 15px;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 186, 0, 0.25);
    }

    /* Sticky Sidebar for desktop */
    @media (min-width: 992px) {
        .sticky-order-box {
            position: sticky;
            top: 100px;
        }
    }

    .product-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .loyalty-section {
        background: #fff8e1;
        border: 1px dashed #ffc107;
        border-radius: 8px;
        padding: 15px;
    }
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Secure Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('trend-era-home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area">
    <div class="container">
        <form class="contact_form" action="{{ route('checkout.post') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-card">
                        <h3 class="section-title">Billing & Shipping</h3>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="fw-bold mb-3"><i class="fa fa-map-marker-alt me-2"></i>Choose a Delivery Address</label>
                                <div class="address-selector">
                                    <div class="address-chip">
                                        <input type="radio" id="addr_home" name="address_type" value="home" 
                                            {{ $customer->selected_add == 1 ? 'checked' : '' }} 
                                            onclick="fillAddress({{ json_encode($customer->address) }})">
                                        <label for="addr_home">Home</label>
                                    </div>

                                    <div class="address-chip">
                                        <input type="radio" id="addr_office" name="address_type" value="office" 
                                            {{ $customer->selected_add == 0 ? 'checked' : '' }} 
                                            onclick="fillAddress({{ json_encode($customer->office_address) }})">
                                        <label for="addr_office">Office</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $customer->first_name ?? auth()->user()->name) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Phone Number</label>
                                <input type="text" class="form-control" name="number" value="{{ old('number', $customer->phone ?? '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $customer->email ?? auth()->user()->email) }}" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="small fw-bold">Street Address</label>
                                <input type="text" class="form-control" name="add1" id="main_address" placeholder="House number and street name" value="{{ old('add1') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Town/City</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Postcode/ZIP</label>
                                <input type="text" class="form-control" name="zip" value="{{ old('zip') }}" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="small fw-bold">Order Notes (Optional)</label>
                                <textarea class="form-control" name="message" rows="3" placeholder="Notes about your delivery...">{{ old('message') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-order-box">
                        <div class="checkout-card">
                            <h3 class="section-title">Your Order</h3>
                            <div class="order-review">
                                <div class="product-list mb-4">
                                    @foreach($allCartItems as $item)
                                    <div class="product-list-item border-bottom">
                                        <div class="text-start">
                                            <p class="mb-0 fw-bold text-dark">{{ $item->product->name }}</p>
                                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                        </div>
                                        <span class="fw-bold">₹{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="totals-area mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal</span>
                                        <span>₹{{ number_format($totalSellingPrice, 2) }}</span>
                                    </div>

                                    @php $coupon = session('coupon'); $couponDiscount = $coupon ? $coupon['discount'] : 0; @endphp
                                    @if($couponDiscount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Coupon ({{ $coupon['code'] }})</span>
                                        <span>- ₹{{ number_format($couponDiscount, 2) }}</span>
                                    </div>
                                    <input type="hidden" value="{{$couponDiscount}}" name="coupon_discount">
                                    <input type="hidden" value="{{$coupon['code']}}" name="coupon_code">
                                    @endif

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Delivery Fee</span>
                                        <span class="{{ $totalDeliveryCharge == 0 ? 'text-success' : '' }}">
                                            {{ $totalDeliveryCharge == 0 ? 'FREE' : '₹'.number_format($totalDeliveryCharge, 2) }}
                                        </span>
                                    </div>

                                    @if ($settings->enable_loyalty == 1 && $availablePoints > 0)
                                    <div class="loyalty-section mt-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="use_points" name="use_points" value="1">
                                                <label class="form-check-label fw-bold" for="use_points">Use Loyalty Points</label>
                                                <div class="small text-muted">Available: {{ $availablePoints }} pts</div>
                                            </div>
                                            <span class="text-success fw-bold">- ₹<span id="points-discount">0.00</span></span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <h4 class="fw-bold">Total</h4>
                                        <h4 class="text-dark fw-bold">₹<span id="display-final-total">{{ number_format($grandTotal, 2) }}</span></h4>
                                        <input type="hidden" name="total_amount" id="input-final-total" value="{{ $grandTotal }}">
                                        <input type="hidden" name="points_redeemed" id="input-points-redeemed" value="0">
                                    </div>
                                </div>

                                <div class="payment-methods">
                                    <h5 class="mb-3 fw-bold">Payment Method</h5>
                                    
                                    <div class="payment_item payment-box active-success mb-3" id="box-cod" onclick="selectPayment('cod')">
                                        <div class="d-flex align-items-center">
                                            <input type="radio" id="f-option5" name="payment_method" value="cod" checked>
                                            <label for="f-option5" class="fw-bold ms-2 mb-0">Cash on Delivery</label>
                                        </div>
                                    </div>

                                    <div class="payment_item payment-box" id="box-stripe" onclick="selectPayment('stripe')">
                                        <div class="d-flex align-items-center">
                                            <input type="radio" id="f-option7" name="payment_method" value="stripe">
                                            <label for="f-option7" class="fw-bold ms-2 mb-0">Credit/Debit Card</label>
                                        </div>
                                        <div id="stripe-card-section" style="display: none;" class="mt-3 pt-3 border-top">
                                            <div id="card-element" class="form-control p-2"></div>
                                            <div id="card-errors" role="alert" class="text-danger small mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="place-order-btn" class="btn btn-warning w-100 fw-bold py-3 mt-4 text-white shadow rounded-pill">
                                    PLACE ORDER NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Logic for filling address
    function fillAddress(address) {
        let addressInput = document.getElementById('main_address');
        if (address && address.toString().trim() !== "") {
            addressInput.value = address;
        } else {
            addressInput.value = "";
            addressInput.focus();
        }
    }

    // Stripe and Stock Check Logic
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        }
    });
    card.mount('#card-element');

    function selectPayment(type) {
        document.querySelectorAll('.payment-box').forEach(box => box.classList.remove('active-success'));
        if (type === 'cod') {
            document.getElementById('box-cod').classList.add('active-success');
            document.getElementById('f-option5').checked = true;
            $('#stripe-card-section').slideUp();
        } else {
            document.getElementById('box-stripe').classList.add('active-success');
            document.getElementById('f-option7').checked = true;
            $('#stripe-card-section').slideDown();
        }
    }

    const form = document.querySelector('.contact_form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const btn = document.getElementById('place-order-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Validating...';

        try {
            const resp = await fetch("{{ route('cart.checkStock') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await resp.json();
            if (!data.success) {
                alert(data.message);
                window.location.href = "{{ route('cart.show') }}";
                return;
            }

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (paymentMethod === 'stripe') {
                const {token, error} = await stripe.createToken(card);
                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    btn.disabled = false;
                    btn.innerHTML = 'PLACE ORDER NOW';
                } else {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            } else {
                form.submit();
            }
        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = 'PLACE ORDER NOW';
            alert('Something went wrong. Please try again.');
        }
    });

    // Loyalty Points Logic
    function calculateTotal() {
        let subtotal = parseFloat("{{ $grandTotal }}") || 0;
        let couponDiscount = parseFloat("{{ $couponDiscount }}") || 0;
        let grandTotal = subtotal - couponDiscount;
        let availablePoints = parseFloat("{{ $availablePoints }}") || 0;
        let pointValue = parseFloat("{{ $pointValue }}") || 0;
        let usePoints = document.getElementById('use_points');
        let discountDisplay = document.getElementById('points-discount');
        let finalTotalDisplay = document.getElementById('display-final-total');
        let finalTotalInput = document.getElementById('input-final-total');
        let pointsRedeemedInput = document.getElementById('input-points-redeemed');

        let discount = 0;
        let pointsUsed = 0;

        if (usePoints && usePoints.checked) {
            let totalPointValue = availablePoints * pointValue;
            discount = Math.min(grandTotal, totalPointValue);
            pointsUsed = discount / pointValue;
        }

        let finalTotal = grandTotal - discount;
        if (discountDisplay) discountDisplay.innerText = discount.toFixed(2);
        if (finalTotalDisplay) finalTotalDisplay.innerText = finalTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        if (finalTotalInput) finalTotalInput.value = finalTotal.toFixed(2);
        if (pointsRedeemedInput) pointsRedeemedInput.value = Math.floor(pointsUsed);
    }

    document.addEventListener("DOMContentLoaded", function() {
        let checkbox = document.getElementById('use_points');
        if (checkbox) checkbox.addEventListener('change', calculateTotal);
        
        let selectedRadio = document.querySelector('input[name="address_type"]:checked');
        if (selectedRadio) selectedRadio.onclick();
        
        calculateTotal();
    });
</script>
@endpush
@endsection