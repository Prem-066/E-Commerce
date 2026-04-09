@php
$cartCount = 0;
if (Auth::check()) {
    $customer = \App\Models\Customer::where('user_id', Auth::id())->first();
    if ($customer) {
        $cartCount = \App\Models\Cart::where('customer_id', $customer->id)->count();
    }
}
@endphp
<header class="header_area sticky-header">
	<div class="main_menu">
		<nav class="navbar navbar-expand-lg navbar-light main_box">
			<div class="container">
				<a class="navbar-brand logo_h" href="{{route('trend-era-home')}}">
					<img src="{{asset('assets/img/llol.png')}}" alt="Trend Era"
						style="height: 50px; width: auto; object-fit: contain;">
				</a>

				<!-- Mobile Direct Icons (Cart & Profile) -->
				<div class="mobile-right-icons d-flex align-items-center d-lg-none" style="position: absolute; right: 70px; top: 15px; gap: 15px;">
					
					<!-- Mobile Cart Icon -->
					<a href="{{ route('cart.show') }}" class="cart position-relative d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px; color: #222;">
						<span class="ti-bag" style="font-size: 20px;"></span>
						<span class="badge badge-warning custom-cart-badge" id="mobile-cart-badge" style="display: {{ $cartCount > 0 ? 'inline-block' : 'none' }};">{{ $cartCount }}</span>
					</a>

					<!-- Mobile Profile Dropdown -->
					<div class="dropdown">
						<a href="#" class="dropdown-toggle d-inline-flex align-items-center justify-content-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #222; width: 35px; height: 35px;">
							<span class="lnr lnr-user" style="font-size: 20px; font-weight: bold;"></span>
						</a>
						<ul class="dropdown-menu custom-mobile-dropdown dropdown-menu-right" style="position: absolute !important; right: 0 !important; left: auto !important; transform: translateX(10%);">
							@if(Auth::check())
							<li class="nav-item">
								<a class="nav-link" href="{{ route('user.profile') }}">My Profile</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('order.history')}}">My Orders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('wishlist.index')}}">Wishlist</a>
							</li>
							<li class="nav-item">
								<form action="{{ route('trend-era-logout') }}" method="POST" id="logout-form-mobile" style="display: none;">@csrf</form>
								<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
							</li>
							@else
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login-front') }}">Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register-front') }}">Register</a>
							</li>
							@endif
						</ul>
					</div>
				</div>

				<!-- Hamburger Menu -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav ml-auto">
						<li class="nav-item {{ Request::is('/') || Request::is('trend-era-home') ? 'active' : '' }}"><a class=" nav-link" href="{{route('trend-era-home')}}">Home</a></li>
						<li class="nav-item {{ Request::routeIs('trend-era-shop') ? 'active' : '' }}"><a class="nav-link" href="{{route('trend-era-shop')}}">Shop</a></li>
						<li class="nav-item {{ Request::routeIs('trend-era-contact') ? 'active' : '' }}"><a class="nav-link" href="{{route('trend-era-contact')}}">Contact</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right d-flex align-items-center" style="flex-direction: row;">
						<li class="nav-item d-none d-lg-block">
							<a href="{{ route('cart.show') }}" class="cart position-relative d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
								<span class="ti-bag" style="font-size: 18px; color: {{ Request::is('trend-era-cart') ? '#ffba00' : '#222' }};"></span>
								<span id="cart-count-badge" class="badge badge-warning custom-cart-badge"
									style="display: {{ $cartCount > 0 ? 'inline-block' : 'none' }};">
									{{ $cartCount }}
								</span>
							</a>
						</li>

						<li class="nav-item px-2">
							<span style="color: #ddd;">|</span>
						</li>

						<li class="nav-item submenu dropdown d-none d-lg-block" style="position: relative;">
							<a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<span class="lnr lnr-user" style="font-size: 16px; font-weight: bold; margin-right: 5px;"></span>
								<span class="profile-text" style="text-transform: uppercase; font-size: 12px; font-weight: 500;">
									{{ Auth::check() ? Auth::user()->name : 'Account' }}
								</span>
							</a>
							<ul class="dropdown-menu custom-mobile-dropdown">
								@if(Auth::check())
								<li class="nav-item {{ Request::is('user-profile') ? 'active' : '' }}">
									<a class="nav-link" href="{{ route('user.profile') }}">My Profile</a>
								</li>
								<li class="nav-item {{ Request::is('trend-era-order-history') ? 'active' : '' }}">
									<a class="nav-link" href="{{route('order.history')}}">My Orders</a>
								</li>
								<li class="nav-item {{ Request::is('wishlist') ? 'active' : '' }}">
									<a class="nav-link" href="{{route('wishlist.index')}}">Wishlist</a>
								</li>
								<li class="nav-item">
									<form action="{{ route('trend-era-logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
									<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
								</li>
								@else
								<li class="nav-item">
									<a class="nav-link" href="{{ route('login-front') }}">Login</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register-front') }}">Register</a>
								</li>
								@endif
							</ul>
						</li>

						<li class="nav-item px-2">
							<span style="color: #ddd;">|</span>
						</li>

						<li class="nav-item d-none d-lg-block">
							<button class="search" style="background: none; border: none; padding: 0;">
								<span class="lnr lnr-magnifier" id="search" style="font-size: 16px; color: #222;"></span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- Mobile Always-Visible Search Bar -->
		<div class="mobile-search-bar d-block d-lg-none px-3 pb-3" style="background: #fff; border-bottom: 1px solid #f1f1f1;">
			<form action="{{ route('trend-era-shop') }}" method="GET" class="d-flex w-100 position-relative">
				<input type="text" name="query" id="mobile_search_input" class="form-control" placeholder="Search products..." style="border-radius: 25px; padding-left: 20px; padding-right: 45px; border: 1px solid #ddd; height: 45px; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);" autocomplete="off">
				<button type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #ffba00;">
					<span class="lnr lnr-magnifier" style="font-size: 18px; font-weight: bold;"></span>
				</button>
                <!-- Mobile Search Results Container -->
				<div id="mobile_search_results_list" style="background: white; position: absolute; width: 100%; top: 50px; z-index: 999; max-height: 250px; overflow-y: auto; box-shadow: 0px 4px 10px rgba(0,0,0,0.15); border-radius: 15px; display: none;">
				</div>
			</form>
		</div>
	</div>

	<div class="search_input" id="search_input_box">
		<div class="container">
			<form class="d-flex justify-content-between" action="{{ route('trend-era-shop') }}" method="GET" id="search_form">
				<input type="text" name="query" class="form-control" id="search_input" placeholder="Search Here" autocomplete="off">
				<button type="submit" class="btn"><i class="lnr lnr-magnifier"></i></button>
				<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
			</form>
			<div id="search_results_list" style="background: white; position: absolute; width: 100%; z-index: 999; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); display: none;">
			</div>
		</div>
	</div>
	<style>
		.custom-cart-badge {
			background-color: #ffba00 !important; 
			color: #fff !important; 
			border-radius: 50% !important; 
			padding: 0 !important;
			width: 16px !important;	
			height: 16px !important;
			line-height: 16px !important;
			text-align: center !important;
			font-size: 10px !important;
			font-weight: bold !important;
			position: absolute !important; 
			top: -2px !important; 
			right: 0px !important; 
			box-shadow: 0px 1px 3px rgba(0,0,0,0.2) !important;
		}

		.header_area .navbar .nav .nav-item.submenu .dropdown-menu {
			margin-top: 0 !important;
			top: 100% !important;
		}

		/* Mobile Specific Fix for Profile Dropdown & Navbar Right Icons */
		@media (max-width: 991px) {
			.navbar-toggler {
				position: absolute;
				right: 15px;
				top: 15px;
			}
			.mobile-right-icons {
				display: flex !important;
				position: absolute;
				top: 15px;
				right: 70px;
			}

			.navbar-right {
				justify-content: center !important;
				padding: 15px 0;
			}

			.navbar-right .nav-item {
				margin: 0 10px;
			}
			
			.profile-text {
				display: none; /* Hide long names on mobile to fit icons */
			}

			.navbar .nav .nav-item.submenu .dropdown-menu.custom-mobile-dropdown {
				position: absolute !important;
				background-color: #fff !important;
				border: 1px solid rgba(0,0,0,0.1);
				box-shadow: 0 4px 10px rgba(0,0,0,0.15);
				min-width: 150px;
				left: 50% !important;
				transform: translateX(-50%);
				right: auto !important;
				z-index: 1050;
				display: none;
			}
			
			.navbar .nav .nav-item.submenu.show .dropdown-menu.custom-mobile-dropdown {
				display: block;
			}

			.custom-mobile-dropdown .nav-item {
				margin: 0 !important;
			}
			
			.custom-mobile-dropdown .nav-link {
				padding: 10px 15px !important;
				color: #222 !important;
				font-size: 14px;
				border-bottom: 1px solid #f1f1f1;
			}
            
            /* Remove border from last item */
            .custom-mobile-dropdown .nav-item:last-child .nav-link {
                border-bottom: none;
            }
		}
	</style>
</header>
@push('scripts')
<script>
	$(document).ready(function() {
		$('#search_input, #mobile_search_input').on('keyup', function() {
			let query = $(this).val();
			let resultsBox = $(this).attr('id') === 'mobile_search_input' ? $('#mobile_search_results_list') : $('#search_results_list');

			if (query.length > 1) { // ૨ અક્ષરથી વધુ ટાઇપ કરે ત્યારે જ સર્ચ થશે
				$.ajax({
					url: "{{ route('trend-era-shop') }}", // આપણે શોપ રૂટનો જ ઉપયોગ કરીએ છીએ
					method: "GET",
					data: {
						'query': query
					},
					dataType: 'json', // JSON રિસ્પોન્સ માંગવો
					success: function(response) {
						let products = response.data; // Paginate હોવાથી response.data માં એરે હશે
						let html = '';

						if (products.length > 0) {
							products.forEach(function(product) {
								let productUrl = "{{ url('trend-era-product-detail') }}/" + product.slug;
								let imageUrl = "{{ asset('storage') }}/" + product.image;

								html += `
                                <a href="${productUrl}" class="d-flex align-items-center p-2 border-bottom text-dark" style="text-decoration: none;">
                                    <img src="${imageUrl}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px;">
                                    <div>
                                        <div style="font-weight: bold; font-size: 14px;">${product.name}</div>
                                        <div style="color: #ffba00; font-size: 13px;">₹${product.price}</div>
                                    </div>
                                </a>
                            `;
							});
							resultsBox.html(html).show();
						} else {
							resultsBox.html('<p class="p-3 text-center">No products found.</p>').show();
						}
					}
				});
			} else {
				resultsBox.hide();
			}
		});

		$(document).on('click', function(e) {
			if (!$(e.target).closest('#search_input_box').length && !$(e.target).closest('.mobile-search-bar').length) {
				$('#search_results_list').hide();
                $('#mobile_search_results_list').hide();
			}
		});
	});
</script>

@endpush