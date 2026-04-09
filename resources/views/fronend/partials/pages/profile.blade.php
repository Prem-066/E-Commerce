@extends('fronend.partials.app')
@section('title', 'My Profile')
@section('contentt')

<style>
    .profile-img-container {
        position: relative;
        display: inline-block;
    }

    .profile-img-container img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
    }

    .profile-upload-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #ffba00;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid #fff;
    }

    .profile-upload-btn:hover {
        background: #f0ad00;
        transform: scale(1.1);
    }

    .profile-upload-btn i {
        font-size: 18px;
    }

    .order_box .list li a i {
        margin-right: 10px;
        color: #ffba00;
    }

    .order_box .list li a.active {
        color: #ffba00 !important;
        font-weight: 600;
    }

    .billing_details h3 {
        font-size: 24px;
        color: #222;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    .p_star label {
        font-size: 14px;
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
        display: block;
    }

    .form-control:focus {
        border-color: #ffba00;
        box-shadow: none;
    }

    .primary-btn {
        background: #ffba00;
        line-height: 40px;
        padding: 0 30px;
        border-radius: 0;
        text-transform: uppercase;
        color: #fff;
        font-weight: 500;
        cursor: pointer;
        display: inline-block;
        border: 1px solid transparent;
        transition: all 0.3s ease 0s;
    }

    .primary-btn:hover {
        background: transparent;
        color: #ffba00;
        border: 1px solid #ffba00;
    }

    /* Custom Pagination Styling */
    .custom-pagination .pagination {
        margin: 0;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 8px;
    }

    .custom-pagination .page-item {
        margin: 0 2px;
    }

    .custom-pagination .page-link {
        color: #ffba00;
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px !important;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 14px;
    }

    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #ffba00 0%, #ff8c00 100%) !important;
        border-color: #ffba00 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(255, 186, 0, 0.3);
        transform: scale(1.05);
    }

    .custom-pagination .page-link:hover {
        background-color: #fff8e1;
        color: #e6a700;
        border-color: #ffba00;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .dashboard-nav .nav-link.active {
        background: #ffba00 !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(255, 186, 0, 0.3);
    }

    .dashboard-nav .nav-link:hover:not(.active) {
        background: #fff8e1;
        color: #ffba00 !important;
    }
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>My Account</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ url('/') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Profile</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area">
    <div class="container">
        <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="order_box" style="padding: 40px 30px; border: none; box-shadow: 0px 10px 30px rgba(0,0,0,0.05); border-radius: 15px; background: #fff;">
                        <div class="text-center">
                            <div class="profile-img-container mb-4">
                                @if($customer && $customer->profile_image)
                                <img id="profile-preview" src="{{ asset('storage/'.$customer->profile_image) }}"
                                    class="rounded-circle shadow-sm" style="border: 4px solid #fff;">
                                @else
                                <img id="profile-preview" src="{{ asset('assets/img/avatar5.png') }}"
                                    class="rounded-circle shadow-sm" style="border: 4px solid #fff;">
                                @endif
                                <label for="profile_image_input" class="profile-upload-btn" title="Change Profile Image">
                                    <i class="lnr lnr-camera"></i>
                                </label>
                                <input type="file" name="profile_image" id="profile_image_input" class="d-none" onchange="previewImage(this)">
                            </div>
                            <h4 class="mb-1 text-dark fw-bold">{{ Auth::user()->name }}</h4>
                            <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                            <div class="mt-3">
                                <span class="badge" style="background: #fff8e1; color: #ffba00; border: 1px solid #ffba00; border-radius: 20px; padding: 5px 15px;">
                                    <i class="lnr lnr-diamond"></i> {{ $customer->loyalty_points ?? 0 }} Points
                                </span>
                            </div>
                            @error('profile_image')
                            <span class="text-danger small d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <ul class="nav flex-column dashboard-nav mt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="nav-item">
                                <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" style="text-decoration: none; border-radius: 10px; margin-bottom: 5px; padding: 12px 20px; color: #666; transition: all 0.3s;">
                                    <i class="lnr lnr-home mr-2"></i> Dashboard Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" style="text-decoration: none; border-radius: 10px; margin-bottom: 5px; padding: 12px 20px; color: #666; transition: all 0.3s;">
                                    <i class="lnr lnr-user mr-2"></i> Edit Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="v-pills-loyalty-tab" data-toggle="pill" href="#v-pills-loyalty" role="tab" style="text-decoration: none; border-radius: 10px; margin-bottom: 5px; padding: 12px 20px; color: #666; transition: all 0.3s;">
                                    <i class="lnr lnr-star mr-2"></i> Loyalty & Rewards
                                </a>
                            </li>
                            <hr class="my-3">
                            <li>
                                <a href="{{ route('order.history') }}" style="text-decoration: none; padding: 12px 20px; display: block; color: #666;">
                                    <i class="lnr lnr-list mr-2"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cart.show') }}" style="text-decoration: none; padding: 12px 20px; display: block; color: #666;">
                                    <i class="lnr lnr-cart mr-2"></i> Shopping Cart
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel">
                            <div class="billing_details" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05);">
                                <h3 class="mb-4">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h3>

                                <div class="row mb-4">
                                    <div class="col-md-3 mb-3">
                                        <div class="p-4 text-center h-100" style="background: #e0f2f1; border-radius: 15px; border: 1px solid rgba(0, 150, 136, 0.1);">
                                            <div class="mb-2" style="font-size: 24px; color: #00897b;"><i class="lnr lnr-list"></i></div>
                                            <h2 class="fw-bold mb-0 counter-value" data-target="{{ $ordersCount }}">0</h2>
                                            <p class="text-muted small mb-0 text-uppercase fw-bold">Total Orders</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-4 text-center h-100" style="background: #fff8e1; border-radius: 15px; border: 1px solid rgba(255, 186, 0, 0.2);">
                                            <div class="mb-2" style="font-size: 24px; color: #ffba00;"><i class="lnr lnr-diamond"></i></div>
                                            <h2 class="fw-bold mb-0 counter-value" data-target="{{ $pointsSummary->confirmed_earned - $pointsSummary->total_redeemed }}">0</h2>
                                            <p class="text-muted small mb-0 text-uppercase fw-bold">Available Points</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-4 text-center h-100" style="background: #f3e5f5; border-radius: 15px; border: 1px solid rgba(156, 39, 176, 0.1);">
                                            <div class="mb-2" style="font-size: 24px; color: #8e24aa;"><i class="lnr lnr-hourglass"></i></div>
                                            <h2 class="fw-bold mb-0 counter-value" data-target="{{ $pointsSummary->pending_earned ? $pointsSummary->pending_earned : 0}}">0</h2>
                                            <p class="text-muted small mb-0 text-uppercase fw-bold">Pending Points</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-4 text-center h-100" style="background: #e3f2fd; border-radius: 15px; border: 1px solid rgba(21, 101, 192, 0.1);">
                                            <div class="mb-2" style="font-size: 24px; color: #1565c0;"><i class="lnr lnr-cart"></i></div>
                                            <h2 class="fw-bold mb-0 counter-value" data-target="{{ $cartCount }}">0</h2>
                                            <p class="text-muted small mb-0 text-uppercase fw-bold">Items in Cart</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="card border-0 shadow-sm p-4" style="border-radius: 15px; background: #fdfdfd;">
                                    <h5 class="fw-bold text-dark mb-3"><i class="lnr lnr-file-empty mr-2 text-warning"></i> Recent Activity</h5>
                                    @if($loyaltyHistory->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($loyaltyHistory->take(3) as $history)
                                        <li class="pb-3 mb-3 border-bottom d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #f8f9fa;">
                                                    @if($history->product_image)
                                                    <img src="{{ asset('storage/' . $history->product_image) }}" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                    <div class="d-flex align-items-center justify-content-center h-100"><i class="lnr lnr-picture text-muted"></i></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-bold text-dark">{{ Str::limit($history->product_name ?? 'Order #'.$history->order_number, 30) }}</p>
                                                    <span class="text-muted small">{{ \Carbon\Carbon::parse($history->created_at)->format('d M, Y') }} • Order Total: ₹{{ number_format($history->total_amount, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                @if($history->type === 'earned')
                                                <span class="text-success fw-bold d-block">+{{ $history->points }}</span>
                                                @endif
                                                @if($history->type === 'redeemed')
                                                <span class="text-danger fw-bold d-block">-{{ $history->points }}</span>
                                                @endif

                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center mt-2">
                                        <a href="javascript:void(0)" onclick="$('#v-pills-loyalty-tab').tab('show')" class="text-warning small fw-bold">View All History <i class="fa fa-arrow-right ml-1"></i></a>
                                    </div>
                                    @else
                                    <p class="text-muted text-center py-4 mb-0">No recent activity found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Profile Tab -->
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel">
                            <div class="billing_details" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05);">
                                <h3 class="mb-4">Profile Information</h3>

                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);">
                                    <i class="fa fa-check-circle mr-2"></i> <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif

                                <div class="row contact_form">
                                    <div class="col-md-4 form-group p_star">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name ?? '' }}" placeholder="First Name" required>
                                        @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 form-group p_star">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" value="{{ $customer->middle_name ?? '' }}" placeholder="Middle Name">
                                    </div>
                                    <div class="col-md-4 form-group p_star">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $customer->last_name ?? '' }}" placeholder="Last Name" required>
                                        @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 form-group p_star">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $customer->phone ?? '' }}" placeholder="Phone Number">
                                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group p_star">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled style="background: #f9f9f9; color: #999;">
                                        <small class="text-muted">Email cannot be changed.</small>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h4 style="font-size: 18px; color: #ffba00; border-bottom: 2px solid #f2f2f2; padding-bottom: 10px; margin-bottom: 20px;">Address Details</h4>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="d-block mb-3">Where do you want to add/update address?</label>

                                        <div class="form-check form-check-inline mr-4">
                                            <input class="form-check-input" type="radio" name="address_type" id="type_home" value="home"
                                                {{ (!isset($customer->selected_add) || $customer->selected_add == 1) ? 'checked' : '' }}
                                                onclick="toggleOfficeAddress(false)">
                                            <label class="form-check-label px-2" for="type_home" style="cursor: pointer;">Home / Residential</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="address_type" id="type_office" value="office"
                                                {{ (isset($customer->selected_add) && $customer->selected_add == 0) ? 'checked' : '' }}
                                                onclick="toggleOfficeAddress(true)">
                                            <label class="form-check-label px-2" for="type_office" style="cursor: pointer;">Office Address</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 form-group p_star" id="home_address_container">
                                        <label>Residential Address</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="Enter Home Address">{{ $customer->address ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-12 form-group p_star" id="office_address_container" style="display: none;">
                                        <label>Office Address</label>
                                        <textarea class="form-control" name="office_address" id="office_address" rows="3" placeholder="Enter Office Address">{{ $customer->office_address ?? '' }}</textarea>
                                    </div>
                                    <input type="hidden" name="selected_add" id="selected_add_input" value="{{ $customer->selected_add ?? 1 }}">

                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="primary-btn border-0 w-100 shadow-sm" style="height: 50px; font-size: 16px; border-radius: 10px;">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loyalty Tab -->
                        <div class="tab-pane fade" id="v-pills-loyalty" role="tabpanel">
                            <div class="billing_details" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0px 10px 30px rgba(0,0,0,0.05);">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="mb-0">Loyalty & Rewards</h3>
                                    <div class="d-flex align-items-center">
                                        <div class="text-end mr-4">
                                            <span class="text-muted small d-block">Pending Balance</span>
                                            <span class="h6 fw-bold text-muted mb-0">{{ $pointsSummary->pending_earned ?? 0}} Points</span>
                                        </div>
                                        <div class="vl mr-4" style="border-right: 1px solid #eee; height: 35px;"></div>
                                        <div class="text-end">
                                            <span class="text-muted small d-block">Available Balance</span>
                                            <span class="h4 fw-bold text-warning mb-0">{{ $customer->loyalty_points ?? 0 }} Points</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="loyalty-info-card p-4 mb-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #f0f4f8 100%); border-radius: 15px; border: 1px solid rgba(0,123,255,0.1); position: relative; overflow: hidden;">
                                    <div style="position: absolute; right: -20px; top: -20px; font-size: 100px; color: rgba(0,123,255,0.05); transform: rotate(-15deg);">
                                        <i class="lnr lnr-diamond"></i>
                                    </div>
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="icon-circle bg-white text-primary shadow-sm d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                            <i class="fa fa-info-circle fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="letter-spacing: 0.5px;">Loyalty Program Benefits</h6>
                                            <div class="d-flex flex-wrap gap-4 text-muted small">
                                                <div class="mr-4">
                                                    <i class="fa fa-tag mr-1 text-primary"></i> 1 Point = <strong>₹{{ number_format($pointValue, 2) }}</strong>
                                                </div>
                                                <div>
                                                    <i class="fa fa-shopping-bag mr-1 text-primary"></i> Get <strong>{{ $settings->points_per_hundred ?? 0 }} Points</strong> / ₹100 spend
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 style="font-size: 20px; color: #333; margin-bottom: 0;">Redeem History</h4>
                                            <span class="text-muted small">Showing last {{ $loyaltyHistory->count() }} transactions</span>
                                        </div>

                                        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead style="background: #f8f9fa;">
                                                        <tr>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold">Order Details</th>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold">Date</th>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold text-end">Order Total</th>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold text-center">Points</th>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold text-center">Status</th>
                                                            <th class="border-0 px-4 py-3 text-uppercase small fw-bold text-end">Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($loyaltyHistory as $history)

                                                        <tr>
                                                            <td class="px-4 py-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3" style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden; background: #f8f9fa; border: 1px solid #eee;">
                                                                        @if($history->product_image)
                                                                        <img src="{{ asset('storage/' . $history->product_image) }}" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                                                                        @else
                                                                        <div class="d-flex align-items-center justify-content-center h-100"><i class="lnr lnr-picture text-muted" style="font-size: 10px;"></i></div>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-bold text-dark d-block">#{{ $history->order_number ?? 'N/A' }}</span>
                                                                        <span class="text-muted small">{{ Str::limit($history->product_name ?? 'Item Detail', 20) }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                <div class="fw-bold text-dark">
                                                                    {{ \Carbon\Carbon::parse($history->created_at)->format('d M, Y') }}
                                                                </div>
                                                                @php
                                                                $lStatus = $history->status ?? 'pending';
                                                                @endphp
                                                                @if($lStatus === 'pending' && $history->type === 'earned' && $history->delivered_at)
                                                                @php
                                                                $deliveryDate = $history->delivered_at;
                                                                $policy = $history->return_policy_days ?? 7;
                                                                $availDate = \Carbon\Carbon::parse($deliveryDate)->addDays($policy);
                                                                @endphp
                                                                <div class="text-muted small mt-1" style="font-size: 10px; line-height: 1.2;">
                                                                    <i class="fas fa-lock me-1"></i> Available On:<br>
                                                                    <span class="fw-bold">{{ $availDate->format('d M, Y') }}</span>
                                                                    @if(!$history->delivered_at)
                                                                    <span class="d-block text-warning" style="font-size: 9px;">(Expecting Delivery)</span>
                                                                    @endif
                                                                </div>
                                                                @elseif($lStatus === 'completed' || $lStatus === 'confirmed')
                                                                <div class="text-success small mt-1" style="font-size: 10px;">
                                                                    <i class="fas fa-check-circle me-1"></i> Available Now
                                                                </div>
                                                                @else
                                                                <!-- <div class="text-danger small mt-1" style="font-size: 10px;">
                                                                    <i class="fas fa-lock me-1"></i> Product is not Deliverd
                                                                </div> -->
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-3 text-end fw-bold text-dark">
                                                                ₹{{ number_format($history->total_amount, 2) }}
                                                            </td>
                                                            <td class="px-4 py-3 text-center">
                                                                <div class="d-flex flex-column align-items-center">
                                                                    @if($history->type === 'earned' && ($lStatus !== 'cancelled'))
                                                                    <div class="mb-1">
                                                                        <span class="badge" style="background: #e8f5e9; color: #2e7d32; border-radius: 6px; padding: 4px 10px; font-size: 11px;">
                                                                            +{{ $history->points }} Earned
                                                                        </span>
                                                                    </div>
                                                                    @elseif($lStatus === 'cancelled')
                                                                    <div class="mb-1">
                                                                        <span class="badge text-muted" style="background: #f5f5f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; opacity: 0.7;">
                                                                            Points Cancelled
                                                                        </span>
                                                                    </div>
                                                                    @endif
                                                                    @if($history->type === 'redeemed')
                                                                    <div>
                                                                        <span class="badge" style="background: #ffebee; color: #c62828; border-radius: 6px; padding: 4px 10px; font-size: 11px;">
                                                                            -{{ $history->points }} Redeemed
                                                                        </span>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-3 text-center">
                                                                @php
                                                                $statusClass = match($lStatus) {
                                                                'completed', 'confirmed' => 'badge-success',
                                                                'pending' => 'badge-warning',
                                                                'cancelled' => 'badge-danger',
                                                                default => 'badge-secondary'
                                                                };
                                                                @endphp
                                                                <span class="badge {{ $statusClass }}" style="border-radius: 20px; padding: 5px 12px; font-size: 10px; text-transform: uppercase;">
                                                                    {{ $lStatus === 'completed' ? 'AVAILABLE' : $lStatus }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-3 text-end fw-bold text-dark">
                                                                @php $netPoints = ($history->type === 'earned' ? 1 : -1) * $history->points; @endphp
                                                                @if($lStatus === 'cancelled')
                                                                <span class="text-muted" style="opacity: 0.5; text-decoration: line-through;">
                                                                    ₹{{ number_format($netPoints * $pointValue, 2) }}
                                                                </span>
                                                                @else
                                                                <span class="{{ $netPoints >= 0 ? 'text-success' : 'text-danger' }}">
                                                                    {{ $netPoints >= 0 ? '+' : '' }}₹{{ number_format($netPoints * $pointValue, 2) }}
                                                                </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-5 text-muted">
                                                                <i class="lnr lnr-history d-block mb-2" style="font-size: 32px; opacity: 0.5;"></i>
                                                                No loyalty history found.
                                                            </td>
                                                        </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex justify-content-center custom-pagination">
                                            {{ $loyaltyHistory->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
</section>

@push('scripts')
<script>
    function toggleOfficeAddress(isOffice) {
        const homeContainer = document.getElementById('home_address_container');
        const officeContainer = document.getElementById('office_address_container');
        const selectedAddInput = document.getElementById('selected_add_input');

        if (isOffice) {
            homeContainer.style.display = 'none';
            officeContainer.style.display = 'block';
            selectedAddInput.value = 0;
        } else {
            homeContainer.style.display = 'block';
            officeContainer.style.display = 'none';
            selectedAddInput.value = 1;
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const typeOffice = document.getElementById('type_office');
        if (typeOffice) {
            toggleOfficeAddress(typeOffice.checked);
        }
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('page')) {
            setTimeout(() => {
                $('#v-pills-loyalty-tab').tab('show');
            }, 100);
        }
        animateCounters();
    });

    function animateCounters() {
        const counters = document.querySelectorAll('.counter-value');
        const speed = 200;

        counters.forEach(counter => {
            const updateCount = () => {
                const target = parseInt(counter.getAttribute('data-target'));
                const count = parseInt(counter.innerText);
                const increment = Math.ceil(target / speed);

                if (count < target) {
                    counter.innerText = count + increment > target ? target : count + increment;
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    }

    // Optionally handle tab hashes for manual navigation
    $(function() {
        var hash = window.location.hash;
        if (hash) {
            $('.dashboard-nav a[href="' + hash + '"]').tab('show');
        }

        $('.dashboard-nav a').on('click', function() {
            window.location.hash = $(this).attr('href');
        });
    });
</script>
@endpush
@endsection