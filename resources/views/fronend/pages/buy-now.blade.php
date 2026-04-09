@extends('fronend.partials.app')
@section('title', 'Buy Now - ' . $product->name)
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

    .product-img-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Fast Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ url('/') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Buy Now</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area section_gap">
    <div class="container">
        <div class="billing_details">
            <form class="row contact_form" action="{{ route('checkout.post') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="buy_now" value="1">

                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="mb-30">Billing Details</h3>
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
                                <li class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img-thumb mr-2">
                                        <span class="text-truncate" style="max-width: 150px;">{{ $product->name }}</span>
                                    </div>
                                    <strong>₹{{ number_format($product->price, 2) }}</strong>
                                </li>
                            </ul>

                            <ul class="list-unstyled border-top mt-3 pt-3">
                                <li class="d-flex justify-content-between">
                                    <strong>Subtotal</strong>
                                    <span class="text-primary fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                </li>
                                @php
                                $loyaltySetting = \App\Models\LoyaltySetting::where('enable_loyalty', 1)->first();
                                @endphp
                                @if($loyaltySetting && $product->price >= $loyaltySetting->min_redeem_points)
                                @if($availablePoints > 0)
                                <li class="mt-3 p-2 border rounded bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <input type="checkbox" id="use_points" name="use_points" value="1" onclick="calculateTotal()">
                                            <label for="use_points" class="ms-1 fw-bold mb-0" style="cursor:pointer;">Use Loyalty Points</label>
                                            <div class="small text-muted ms-4">
                                                Available: <span id="display-available-points">{{ $availablePoints }}</span> Points
                                            </div>
                                        </div>
                                        <span class="text-success fw-bold">- ₹<span id="points-discount">0.00</span></span>
                                    </div>
                                </li>
                                @endif
                                @endif
                                <input type="hidden" name="points_redeemed" id="input-points-redeemed" value="0">

                                <li class="d-flex justify-content-between border-top mt-3 pt-2">
                                    <h4>Total</h4>
                                    <h4 class="text-dark fw-black">₹<span id="display-final-total">{{ number_format($product->price, 2) }}</span></h4>
                                    <input type="hidden" name="total_amount" id="input-final-total" value="{{ $product->price }}">
                                </li>
                            </ul>

                            {{-- Payment Methods --}}
                            <div class="payment_item border rounded p-3 mb-3 bg-white payment-box active-success" id="box-cod">
                                <input type="radio" id="cod" name="payment_method" value="cod" checked onclick="selectPayment('cod')">
                                <label for="cod" class="fw-bold ms-2">Cash on Delivery</label>
                            </div>

                            <div class="payment_item border rounded p-3 bg-white payment-box" id="box-stripe">
                                <input type="radio" id="stripe" name="payment_method" value="stripe" onclick="selectPayment('stripe')">
                                <label for="stripe" class="fw-bold ms-2">Online Payment (Card)</label>
                                <div id="stripe-card-section" style="display: none;" class="mt-3">
                                    <div id="card-element" class="form-control"></div>
                                    <div id="card-errors" class="text-danger small mt-2"></div>
                                </div>
                            </div>

                            <button type="submit" class="primary-btn w-100 border-0 mt-4 shadow">CONFIRM ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // ૧. Stripe Logic
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    function selectPayment(type) {
        $('.payment-box').removeClass('active-success');
        if (type === 'cod') {
            $('#box-cod').addClass('active-success');
            $('#stripe-card-section').slideUp();
        } else {
            $('#box-stripe').addClass('active-success');
            $('#stripe-card-section').slideDown();
        }
    }

    function calculateTotal() {
        let grandTotal = parseFloat("{{ $grandTotal }}") || 0;
        let initialAvailablePoints = parseFloat("{{ $availablePoints }}") || 0;
        let pointValue = parseFloat("{{ $pointValue }}") || 0;

        let usePoints = document.getElementById('use_points');
        let discountDisplay = document.getElementById('points-discount');
        let finalTotalDisplay = document.getElementById('display-final-total');
        let availableDisplay = document.getElementById('display-available-points');

        let finalTotalInput = document.getElementById('input-final-total');
        let pointsRedeemedInput = document.getElementById('input-points-redeemed');

        let discount = 0;
        let pointsUsed = 0;

        if (usePoints && usePoints.checked) {
            let totalPointValue = initialAvailablePoints * pointValue;

            discount = Math.min(grandTotal, totalPointValue);
            pointsUsed = Math.floor(discount / pointValue);
        }

        let finalTotal = grandTotal - discount;
        let remainingPoints = initialAvailablePoints - pointsUsed;

        if (discountDisplay) discountDisplay.innerText = discount.toFixed(2);

        if (finalTotalDisplay) {
            finalTotalDisplay.innerText = finalTotal.toLocaleString('en-IN', {
                minimumFractionDigits: 2
            });
        }

        if (availableDisplay) {
            availableDisplay.innerText = remainingPoints;
        }

        if (finalTotalInput) finalTotalInput.value = finalTotal.toFixed(2);
        if (pointsRedeemedInput) pointsRedeemedInput.value = pointsUsed;
    }

    $('#use_points').change(calculateTotal);

    function fillAddress(addr) {
        $('#main_address').val(addr);
    }

    $('#payment-form').submit(async function(e) {
        if ($('input[name="payment_method"]:checked').val() === 'stripe') {
            e.preventDefault();
            const {
                token,
                error
            } = await stripe.createToken(card);
            if (error) {
                $('#card-errors').text(error.message);
            } else {
                $(this).append(`<input type="hidden" name="stripeToken" value="${token.id}">`);
                this.submit();
            }
        }
    });
</script>
@endpush

@endsection