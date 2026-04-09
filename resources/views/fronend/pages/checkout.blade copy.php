@extends('fronend.partials.app')
@section('title','Product cart')
@section('contentt')

<style>
    .payment-box {
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0 !important;
    }

    .active-success {
        border-color: #28a745 !important;
        background-color: #f8fff9 !important;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.1) !important;
    }

    .active-success input[type="radio"] {
        accent-color: #28a745;
    }
</style>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('trend-era-home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>


<section class="checkout_area section_gap">
    <div class="container">
        <div class="billing_details">
            <form class="row contact_form" action="{{ route('checkout.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="mb-30">Billing Details</h3>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 form-group mb-4">
                                <label class="fw-bold mb-2">Select Delivery Address:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @if($customer && $customer->address)
                                    <div class="payment_item border p-2 rounded">
                                        <input type="radio" id="addr_home" name="address_type" value="home"
                                            {{ $customer->selected_add == 1 ? 'checked' : '' }}
                                            onclick="fillAddress({{ json_encode($customer->address) }})">
                                        <label for="addr_home" class="ms-1">Home Address</label>
                                    </div>
                                    @endif

                                    @if($customer && $customer->office_address)

                                    <div class="payment_item border p-2 rounded">
                                        <input type="radio" id="addr_office" name="address_type" value="office"
                                            {{ $customer->selected_add == 0 ? 'checked' : '' }}
                                            onclick="fillAddress({{ json_encode($customer->office_address) }})">
                                        <label for="addr_office" class="ms-1">Office Address</label>
                                    </div>
                                    @endif

                                    <div class="payment_item border p-2 rounded">
                                        <input type="radio" id="addr_new" name="address_type" value="new"
                                            {{ is_null($customer->selected_add) ? 'checked' : '' }}
                                            onclick="fillAddress('')">
                                        <label for="addr_new" class="ms-1">Other / New Address</label>
                                    </div>
                                </div>
                                @error('address_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $customer->first_name ?? auth()->user()->name) }}" required>
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" required>
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="number" value="{{ old('number', $customer->phone ?? '') }}" required>
                                @error('number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="small fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $customer->email ?? auth()->user()->email) }}" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="small fw-bold">Street Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="add1" id="main_address"
                                    placeholder="House number and street name" value="{{ old('add1') }}" required>
                                @error('add1')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="small fw-bold">Town/City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="small fw-bold">Postcode/ZIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="zip" value="{{ old('zip') }}" required>
                                @error('zip')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control mt-3" name="message" rows="3" placeholder="Order Notes (Optional)">{{ old('message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="order_box p-4 bg-light rounded shadow-sm border">
                            <h2 class="border-bottom pb-3 mb-3 fw-bold">Your Order</h2>

                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between border-bottom pb-2">
                                    <strong>Product</strong>
                                    <strong>Total</strong>
                                </li>

                                @foreach($allCartItems as $item)
                                <li class="d-flex justify-content-between mt-3">
                                    <span class="text-truncate" style="max-width: 180px;">
                                        {{ $item->product->name }} <br><strong>x {{ $item->quantity }}</strong>
                                    </span>
                                    <span>₹{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </li>
                                @endforeach
                            </ul>

                            <ul class="list-unstyled border-top mt-3 pt-3">
                                <li class="d-flex justify-content-between">
                                    <strong>Subtotal</strong>
                                    <span class="text-primary fw-bold">₹{{ number_format($totalSellingPrice, 2) }}</span>
                                </li>

                                @php
                                $coupon = session('coupon');
                                $couponDiscount = $coupon ? $coupon['discount'] : 0;
                                @endphp

                                @if($couponDiscount > 0)
                                <li class="d-flex justify-content-between mt-2">
                                    <strong>Coupon Discount ({{ $coupon['code'] }})</strong>
                                    <span class="text-success fw-bold">- ₹{{ number_format($couponDiscount, 2) }}</span>
                                </li>
                                <input type="hidden" value="{{$couponDiscount}}" name="coupon_discount">
                                <input type="hidden" value="{{$coupon['code']}}" name="coupon_code">
                                @endif

                                <li class="d-flex justify-content-between mt-2">
                                    <strong>Delivery Fee</strong>
                                    @if($totalDeliveryCharge == 0)
                                    <span class="text-success fw-bold">FREE</span>
                                    @else
                                    <span class="text-success fw-bold">+ ₹{{ number_format($totalDeliveryCharge, 2) }}</span>
                                    @endif
                                </li>
                                @if ($settings->enable_loyalty ==1)
                                @if($availablePoints > 0)
                                <li class="mt-3 p-2 border rounded bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <input type="checkbox" id="use_points" name="use_points" value="1">
                                            <label for="use_points" class="ms-1 fw-bold mb-0" style="cursor:pointer;">Use Loyalty Points</label>
                                            <div class="small text-muted ms-4">Available: {{ $availablePoints }} Points</div>
                                        </div>
                                        <span class="text-success fw-bold">- ₹<span id="points-discount">0.00</span></span>
                                    </div>
                                </li>
                                @endif
                                @endif



                                <li class="d-flex justify-content-between border-top mt-2 pt-2">
                                    <h4>Total</h4>
                                    <h4 class="text-dark fw-black">₹<span id="display-final-total">{{ number_format($grandTotal, 2) }}</span></h4>

                                    <input type="hidden" name="total_amount" id="input-final-total" value="{{ $grandTotal }}">
                                    <input type="hidden" name="points_redeemed" id="input-points-redeemed" value="0">
                                </li>
                            </ul>

                            <div class="payment_item border rounded p-3 mb-3 bg-white shadow-sm payment-box active-success" id="box-cod">
                                <div class="radion_btn d-flex align-items-center">
                                    <input type="radio" id="f-option5" name="payment_method" value="cod" checked onclick="selectPayment('cod')">
                                    <label for="f-option5" class="fw-bold ms-2 mb-0" style="cursor:pointer;">Cash on Delivery</label>
                                </div>
                                <p class="small text-muted mt-2 mb-0 ms-4">Pay when you receive the product at your doorstep.</p>
                            </div>

                            <div class="payment_item border rounded p-3 bg-white shadow-sm payment-box" id="box-stripe">
                                <div class="radion_btn d-flex align-items-center">
                                    <input type="radio" id="f-option7" name="payment_method" value="stripe" onclick="selectPayment('stripe')">
                                    <label for="f-option7" class="fw-bold ms-2 mb-0" style="cursor:pointer;">Stripe (Card Payment)</label>
                                </div>

                                <div id="stripe-card-section" style="display: none;" class="mt-3 pt-3 border-top">
                                    <label for="card-element" class="small fw-bold text-muted mb-2">CARD DETAILS</label>
                                    <div id="card-element" class="form-control p-2"></div>
                                    <div id="card-errors" role="alert" class="text-danger small mt-2"></div>
                                </div>
                            </div>

                            <script src="https://js.stripe.com/v3/"></script>
                            <button type="submit" id="place-order-btn" class="btn btn-warning w-100 fw-bold py-3 mt-4 text-white shadow">
                                PLACE ORDER
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@push('scripts')
<script>
    function fillAddress(address) {
        console.log("Selected Address: ", address);
        let addressInput = document.getElementById('main_address');

        if (address && address.toString().trim() !== "") {
            addressInput.value = address;
        } else {
            addressInput.value = "";
            addressInput.focus();
        }
    }
</script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            if (event.target.value === "stripe") {
                document.getElementById('stripe-card-section').style.display = 'block';
            } else {
                document.getElementById('stripe-card-section').style.display = 'none';
            }
        });
    });

    const form = document.querySelector('.contact_form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); // Stop initial submission to perform checks

        const btn = document.getElementById('place-order-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Checking Stock...';

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

            // If stock ok, proceed with current logic
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (paymentMethod === 'stripe') {
                const {
                    token,
                    error
                } = await stripe.createToken(card);

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    btn.disabled = false;
                    btn.innerHTML = 'PLACE ORDER';
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
            console.error(err);
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerHTML = 'PLACE ORDER';
        }
    });
</script>
<script>
    function selectPayment(type) {
        document.querySelectorAll('.payment-box').forEach(box => {
            box.classList.remove('active-success');
        });
        if (type === 'cod') {
            document.getElementById('box-cod').classList.add('active-success');
            $('#stripe-card-section').slideUp();
        } else {
            document.getElementById('box-stripe').classList.add('active-success');
            $('#stripe-card-section').slideDown();
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedRadio = document.querySelector('input[name="address_type"]:checked');
        if (selectedRadio) {
            selectedRadio.onclick();
        }
    });
</script>
<script>
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

            console.log("Discount Applied: ₹" + discount);
        } else {
            console.log("Points Unchecked");
        }

        let finalTotal = grandTotal - discount;

        if (discountDisplay) discountDisplay.innerText = discount.toFixed(2);
        if (finalTotalDisplay) finalTotalDisplay.innerText = finalTotal.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        });

        if (finalTotalInput) finalTotalInput.value = finalTotal.toFixed(2);
        if (pointsRedeemedInput) pointsRedeemedInput.value = Math.floor(pointsUsed);
    }
    document.addEventListener("DOMContentLoaded", function() {
        let checkbox = document.getElementById('use_points');
        if (checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        }
        calculateTotal();
    });
</script>

@endpush
@endsection