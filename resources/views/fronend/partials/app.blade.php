<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	@php
	$settings=DB::table('settings')->first();
	@endphp
	@if($settings && $settings->favicon)
	<link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings->favicon) }}">
	@else
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
	@endif
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Karma Shop</title>
	<!--
		CSS
		============================================= -->
	@include('fronend.partials.header_links')
</head>

<body>

	<!-- Start Header Area -->
	@include('fronend.partials.header')

	@yield('contentt')

	<!-- start footer Area -->
	@include('fronend.partials.footer')
	<!-- End footer Area -->

	@include('fronend.partials.footer_links')
	@stack('scripts')
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			if (!sessionStorage.getItem('location_set')) {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(
						function(position) {
							let lat = position.coords.latitude;
							let lon = position.coords.longitude;

							fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
								.then(response => response.json())
								.then(data => {
									let city = data.address.city || data.address.town || data.address.village || data.address.suburb;

									if (city) {
										fetch('/save-location', {
												method: 'POST',
												headers: {
													'Content-Type': 'application/json',
													'X-Requested-With': 'XMLHttpRequest',
													'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
												},
												body: JSON.stringify({
													city: city
												})
											})
											.then(response => response.json())
											.then(data => {
												if (data.status === 'success') {
													sessionStorage.setItem('location_set', 'true');
													location.reload();
												}
											})
											.catch(error => console.error('Save Location Error:', error));
									}
								})
								.catch(error => console.error('Geocoding Error:', error));
						},
						function(error) {
							if (error.code === error.PERMISSION_DENIED) {
								alert("તમારા શહેરની પ્રોડક્ટ્સ અને સ્ટોર જોવા માટે લોકેશન Allow કરવું ફરજિયાત છે.");
								location.reload();
							}
						}, {
							enableHighAccuracy: true,
							timeout: 5000,
							maximumAge: 0
						}
					);
				} else {
					alert("તમારું બ્રાઉઝર લોકેશન સપોર્ટ કરતું નથી.");
				}
			}
		});
	</script>
</body>

</html>