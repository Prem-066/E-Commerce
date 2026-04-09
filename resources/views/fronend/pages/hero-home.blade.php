@extends('fronend.partials.app')
@section('title','Home')
@section('contentt')
<section class="banner-area">
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-start">
            <div class="col-lg-12">
                <div class="active-banner-slider owl-carousel">
                    @foreach($bannerProducts as $product)
                    <div class="row single-slide align-items-center d-flex">
                        <div class="col-lg-5 col-md-6">
                            <div class="banner-content">
                                <h2>{{ $product->name }}</h2>
                                <p>{!! Str::limit($product->description, 100) !!}</p>
                                <div class="add-bag d-flex align-items-center">
                                    <a class="add-btn" href="{{ route('product-detail', $product->slug) }}">
                                        <span class="lnr lnr-arrow-right"></span>
                                    </a>
                                    <span class="add-text text-uppercase">View Product</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img-container">
                                <img class="img-fluid custom-banner-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <style>
                    .single-slide {
                        height: 500px;
                        overflow: hidden;
                    }

                    .banner-img-container {
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 50px;
                    }

                    .custom-banner-img {
                        width: auto !important;
                        margin: 0 auto;
                        display: block;
                        object-fit: contain;
                    }

                    @media (max-width: 768px) {
                        .single-slide {
                            height: auto;
                            padding: 50px 0;
                            text-align: center;
                        }

                        .banner-content {
                            margin-bottom: 30px;
                        }

                        .banner-content h1 {
                            font-size: 28px;
                            line-height: 1.2;
                        }

                        .banner-content p {
                            font-size: 14px;
                            margin-bottom: 20px;
                        }

                        .add-bag {
                            justify-content: center;
                        }

                        .custom-banner-img {
                            max-height: 300px !important;
                            width: 80% !important;
                        }

                        .single-slide {
                            display: flex !important;
                            flex-direction: column-reverse;
                        }
                    }

                    @media (max-width: 480px) {
                        .banner-content h1 {
                            font-size: 22px;
                        }

                        .custom-banner-img {
                            max-height: 250px !important;
                        }
                    }
                </style>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<!-- start features Area -->
<section class="features-area section_gap mt-3">
    <div class="container">
        <div class="row features-inner d-flex flex-nowrap overflow-auto-mobile">

            <div class="col-3 custom-feature-col">
                <div class="single-features text-center">
                    <div class="f-icon">
                        <img src="{{ asset('assets/img/features/f-icon1.png')}}" class="img-fluid" alt="">
                    </div>
                    <h6>Free Delivery</h6>
                    <p class="d-none d-md-block">Free Shipping on all order</p>
                </div>
            </div>

            <div class="col-3 custom-feature-col">
                <div class="single-features text-center">
                    <div class="f-icon">
                        <img src="{{ asset('assets/img/features/f-icon2.png')}}" class="img-fluid" alt="">
                    </div>
                    <h6>Return Policy</h6>
                    <p class="d-none d-md-block">Free Shipping on all order</p>
                </div>
            </div>

            <div class="col-3 custom-feature-col">
                <div class="single-features text-center">
                    <div class="f-icon">
                        <img src="{{ asset('assets/img/features/f-icon3.png')}}" class="img-fluid" alt="">
                    </div>
                    <h6>24/7 Support</h6>
                    <p class="d-none d-md-block">Free Shipping on all order</p>
                </div>
            </div>

            <div class="col-3 custom-feature-col">
                <div class="single-features text-center">
                    <div class="f-icon">
                        <img src="{{ asset('assets/img/features/f-icon4.png')}}" class="img-fluid" alt="">
                    </div>
                    <h6>Secure Payment</h6>
                    <p class="d-none d-md-block">Free Shipping on all order</p>
                </div>
            </div>

        </div>
    </div>
</section>
<style>
    .custom-cat-img {
        height: 250px;
        object-fit: cover;
        object-position: center;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .custom-cat-img {
            height: 180px;
        }
    }

    @media (max-width: 575px) {
        .custom-cat-img {
            height: 140px;
        }

        .deal-details h6 {
            font-size: 12px;
            padding: 5px 10px;
        }

        .single-deal {
            margin-bottom: 15px;
        }

        .gx-2 {
            --bs-gutter-x: 0.5rem;
        }
    }

    .single-deal {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .single-deal:hover {
        transform: scale(1.02);
    }

    .product-card-img,
    .single-product>img.img-fluid {
        width: 100%;
        height: 220px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .single-product {
        display: flex;
        flex-direction: column;
    }

    .single-product .product-details,
    .flex-grow-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .single-product .prd-bottom {
        margin-top: auto;
    }

    @media (max-width: 575px) {

        .product-card-img,
        .single-product>img.img-fluid {
            height: 150px;
        }
    }

    .mobile-label {
        font-size: 0.65rem !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2;
    }

    .social-info,
    .social-info:hover,
    .social-info:focus {
        text-decoration: none !important;
    }

    .hover-text,
    .mobile-label {
        text-decoration: none !important;
    }
</style>
<!-- Start category Area -->
<section class="category-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="row gx-2 px-2">
                    @foreach($categories->take(4) as $index => $category)
                    <div class="col-lg-{{ ($index == 0 || $index == 3) ? '7' : '5' }} col-md-6 col-6 mb-3">
                        <div class="single-deal h-100">
                            <div class="overlay"></div>
                            @php
                            $randomProduct = $category->products->first();
                            $displayImage = ($randomProduct && $randomProduct->image)
                            ? asset('storage/' . $randomProduct->image)
                            : asset('assets/img/category/default.jpg');
                            @endphp

                            <img class="img-fluid w-100 custom-cat-img" src="{{ $displayImage }}" alt="{{ $category->name }}">

                            <a href="{{ route('trend-era-shop', ['category' => $category->id]) }}">
                                <div class="deal-details">
                                    <h6 class="deal-title">{{ $category->name }}</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(isset($categories[4]))
            <div class="col-lg-4 col-md-6 col-6 mb-3 px-2">
                <div class="single-deal h-100">
                    <div class="overlay"></div>
                    @php
                    $randomProduct5 = $categories[4]->products->first();
                    $displayImage5 = $randomProduct5 ? asset('storage/' . $randomProduct5->image) : asset('assets/img/category/default.jpg');
                    @endphp
                    <img class="img-fluid w-100 custom-cat-img" src="{{ $displayImage5 }}" alt="{{ $categories[4]->name }}">
                    <a href="{{ route('trend-era-shop', ['category' => $categories[4]->id]) }}">
                        <div class="deal-details">
                            <h6 class="deal-title">{{ $categories[4]->name }}</h6>
                        </div>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- End category Area -->

<!-- start product Area -->
<section class="active-product-area section_gap">
    <!-- single product slide -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Latest Products</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-stretch">
                @forelse($products as $product)
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex">
                    <div class="single-product h-100 w-100">
                        <img class="product-card-img" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        <div class="product-details flex-grow-details">
                            <h6>{{$product->name}}</h6>
                            <div class="price">
                                <h6>₹{{$product->price}}</h6>
                                <h6 class="l-through">₹{{$product->discount_price}}</h6>
                            </div>
                            <div class="prd-bottom d-flex justify-content-center justify-content-md-start">
                                <a href="{{route('add.to.cart', $product->slug)}}" class="social-info d-flex align-items-center mr-2">
                                    <span class="ti-bag" style="font-size: 1.2rem;"></span>
                                    <p class="hover-text d-none d-md-block ml-1">add to bag</p>
                                    <p class="hover-text d-block d-md-none ml-1 mobile-label">Bag</p>
                                </a>

                                <a href="{{ route('wishlist.add', $product->id) }}" class="social-info d-flex align-items-center mr-2">
                                    <span class="lnr lnr-heart" style="font-size: 1.2rem;"></span>
                                    <p class="hover-text d-none d-md-block ml-1">Wishlist</p>
                                    <p class="hover-text d-block d-md-none ml-1 mobile-label">Fav.</p>
                                </a>

                                <a href="{{route('product-detail',$product->slug)}}" class="social-info d-flex align-items-center">
                                    <span class="lnr lnr-move" style="font-size: 1.2rem;"></span>
                                    <p class="hover-text ml-1">view</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @empty.
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="section-title">
                            <h1>No Products Found</h1>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
    <!-- single product slide -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Coming Products</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p6.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p8.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p3.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p5.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p1.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p4.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p1.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single product -->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="single-product">
                        <img class="img-fluid" src="{{asset('assets/img/product/p8.jpg')}}" alt="">
                        <div class="product-details">
                            <h6>addidas New Hammer sole
                                for Sports person</h6>
                            <div class="price">
                                <h6>$150.00</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">

                                <a href="" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-sync"></span>
                                    <p class="hover-text">compare</p>
                                </a>
                                <a href="" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end product Area -->

<!-- Start exclusive deal Area -->
<section class="exclusive-deal-area">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 no-padding exclusive-left">
                <div class="row clock_sec clockdiv" id="clockdiv">
                    <div class="col-lg-12">
                        <h1>Exclusive Hot Deal Ends Soon!</h1>
                        <p>Who are in extremely love with eco friendly system.</p>
                    </div>
                    <div class="col-lg-12">
                        <div class="row clock-wrap">
                            <div class="col clockinner1 clockinner">
                                <h1 class="days">150</h1>
                                <span class="smalltext">Days</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="hours">23</h1>
                                <span class="smalltext">Hours</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="minutes">47</h1>
                                <span class="smalltext">Mins</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="seconds">59</h1>
                                <span class="smalltext">Secs</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="" class="primary-btn">Shop Now</a>
            </div>
            <div class="col-lg-6 no-padding exclusive-right">
                <div class="active-exclusive-product-slider owl-carousel">
                    @foreach($exclusiveProducts as $product)
                    <div class="single-exclusive-slider">
                        <img class="img-fluid" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 300px; object-fit: contain; width: 100%;">
                        <div class="product-details">
                            <div class="price">
                                <h6>₹{{ $product->price }}</h6>
                                <h6 class="l-through">₹{{$product->discount_price}}</h6>
                            </div>
                            <h4>{{ $product->name }}</h4>
                            <div class="add-bag d-flex align-items-center justify-content-center">
                                <a class="add-btn" href="{{ route('product-detail', $product->slug) }}">
                                    <span class="ti-arrow-right"></span>
                                </a>
                                <span class="add-text text-uppercase">View Product</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End exclusive deal Area -->

<section class="brand-area section_gap">
    <div class="container">
        <div class="active-brand-slider owl-carousel">
            @foreach($brands->chunk(5) as $brandChunk)
            <div class="row">
                @foreach($brandChunk as $brand)
                <div class="col text-center single-img">
                    <img class="img-fluid mx-auto"
                        src="{{ asset('storage/' . $brand->logo)}}"
                        alt="{{ $brand->name }}">
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .single-img {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .single-img img {
        width: 120px;
        height: 80px;
        object-fit: contain;
    }
</style>
<!-- End brand Area -->

<!-- Start related-product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Deals of the Week</h1>
                    <p>Your favorite products at amazing prices and discounts. New deals every week!</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @forelse($deals as $deal)
                    <div class="col-6 col-md-6 col-lg-4 mb-20">
                        <div class="single-related-product d-flex align-items-center">
                            <a href="#">
                                <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->name }}"
                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                            </a>
                            <div class="desc ml-3">
                                <a href="{{ route('product-detail', $deal->slug) }}" class="title fw-bold text-dark" style="text-decoration: none">{{ Str::limit($deal->name, 20) }}</a>
                                <div class="price">
                                    <h6 class="text-primary">₹{{ number_format($deal->price) }}</h6>
                                    @if($deal->original_price)
                                    <h6 class="l-through text-muted">₹{{ number_format($deal->original_price) }}</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No deals available.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{ asset('assets/img/category/c5.jpg') }}" alt="Special Offer">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $('.active-brand-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3500,
        nav: false,
        dots: false
    });
</script>

@endpush
<!-- End related-product Area -->
@endsection