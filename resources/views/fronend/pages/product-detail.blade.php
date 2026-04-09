@extends('fronend.partials.app')
@section('title','Product Detail')
@section('contentt')
<style>
    /* Table responsive */
    #profile table {
        width: 100% !important;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    #profile {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    #profile table td,
    #profile table th {
        padding: 12px;
        border: 1px solid #dee2e6;
    }

    /* ===== Mobile Product Detail Improvements ===== */

    /* Product image box */
    .prd-img-box {
        height: 550px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #8689b1;
        padding: 15px;
        border-radius: 5px;
    }

    /* Sticky bottom action bar - mobile only */
    .mobile-sticky-bar {
        display: none;
    }

    /* Nav tabs scrollable on mobile */
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .nav-tabs .nav-item {
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        /* Smaller image on mobile */
        .prd-img-box {
            height: 300px;
            padding: 10px;
        }

        /* Product name & price */
        .s_product_text h3 {
            font-size: 1.2rem !important;
        }
        .s_product_text h2 {
            font-size: 1.4rem !important;
        }

        /* Buttons full width on mobile */
        .card_area {
            flex-direction: column;
            gap: 10px;
        }
        .card_area .primary-btn {
            width: 100%;
            text-align: center;
            display: block;
            padding: 12px !important;
            font-size: 1rem;
        }
        .card_area span.ms-3 {
            margin-left: 0 !important;
        }

        /* Show sticky bottom bar on mobile */
        .mobile-sticky-bar {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 999;
            background: #fff;
            border-top: 1px solid #ddd;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.12);
            padding: 10px 12px;
            gap: 10px;
        }
        .mobile-sticky-bar a {
            flex: 1;
            text-align: center;
            padding: 11px 5px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
        }
        .mobile-sticky-bar .btn-cart {
            background: #f8f9fa;
            border: 2px solid #f7a707;
            color: #f7a707;
        }
        .mobile-sticky-bar .btn-buy {
            background: #28a745;
            color: #fff;
        }

        /* Add bottom padding so sticky bar doesn't cover content */
        .product_description_area,
        .related-product-area {
            padding-bottom: 80px;
        }

        /* Breadcrumb smaller */
        .breadcrumb-banner h1 {
            font-size: 1rem !important;
        }
        .breadcrumb-banner nav a {
            font-size: 0.8rem;
        }

        /* Table font */
        #profile table {
            font-size: 13px;
        }

        /* Related products full width on mobile */
        .col-lg-3.d-lg-block {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .prd-img-box {
            height: 240px;
        }
    }
</style>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Product Details Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{route('trend-era-home')}}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{route('trend-era-shop')}}">Shop<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{route('product-detail',$productDetail->slug)}}">product-details</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        <div class="prd-img-box">
                            <img class="img-fluid"
                                src="{{ asset('storage/' . $productDetail->image) }}"
                                alt="{{ $productDetail->name }}"
                                style="height:100%; width:100%; object-fit:contain;">
                        </div>
                    </div>

                    @foreach($productImg as $image)
                    <div class="single-prd-item">
                        <div class="prd-img-box">
                            <img class="img-fluid"
                                src="{{ asset('storage/'.$image->image_path) }}"
                                alt="Product Image"
                                style="height:100%; width:100%; object-fit:contain;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3 class="mb-3 fw-bold text-dark">{{ $productDetail->name }}</h3>

                    <div class="d-flex align-items-center mb-4">
                        <h2 class="mb-0 fw-bold text-primary me-3">₹{{ number_format($productDetail->price) }}</h2>

                        @if($productDetail->discount_price)
                        <span class="text-muted primary text-decoration-line-through fs-5">
                            ₹{{ number_format($productDetail->discount_price) }}
                        </span>

                        @php
                        $discount = round((($productDetail->discount_price - $productDetail->price) / $productDetail->discount_price) * 100);
                        @endphp
                        <span class="badge bg-warning ms-3">{{ $discount }}% OFF</span>
                        @endif
                    </div>

                    <p class="text-secondary leading-relaxed">
                        {!! $productDetail->sort_description !!}
                    </p>
                    <div class="card_area d-flex align-items-center flex-wrap">
                        @if($productDetail->stock > 20)
                        <!-- <a class="primary-btn text-decoration-none me-2"
                            href="{{ route('add.to.cart', $productDetail->slug) }}">
                            <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                        </a> -->
                        <a href="javascript:void(0)"
                            class="primary-btn text-decoration-none me-2 add-to-cart-btn"
                            data-url="{{ route('add.to.cart', $productDetail->slug) }}">
                            <i class="fa fa-shopping-cart me-2"></i> Add to Cartt
                        </a>
                        <a class="primary-btn text-decoration-none bg-success border-0"
                            href="{{ route('buy-now', $productDetail->slug) }}">
                            <i class="fa fa-bolt me-2"></i> Buy Now
                        </a>
                        @elseif($productDetail->stock <= 20 && $productDetail->stock > 0)
                            <!-- <a class="primary-btn text-decoration-none me-2"
                                href="{{ route('add.to.cart', $productDetail->slug) }}">
                                <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                            </a> -->
                            <a href="javascript:void(0)"
                                class="primary-btn text-decoration-none me-2 add-to-cart-btn"
                                data-url="{{ route('add.to.cart', $productDetail->slug) }}">
                                <i class="fa fa-shopping-cart me-2"></i> Add to Cartt
                            </a>
                            <a class="primary-btn text-decoration-none bg-success border-0"
                                href="{{ route('buy-now', $productDetail->slug) }}">
                                <i class="fa fa-bolt me-2"></i> Buy Now
                            </a>
                            <span class="ms-3 text-danger fw-bold" style="font-size:14px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                Only {{ $productDetail->stock }} available! Hurry up!
                            </span>
                            @else
                            <a class="primary-btn text-decoration-none bg-secondary border-0"
                                href="javascript:void(0)"
                                style="cursor:not-allowed;">
                                Out of Stock
                            </a>
                            <span class="ms-3 text-danger fw-bold" style="font-size:14px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                Out of Stock
                            </span>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mobile Sticky Bottom Bar --}}
@if($productDetail->stock > 0)
<div class="mobile-sticky-bar d-lg-none">
    <a href="javascript:void(0)"
        class="btn-cart add-to-cart-btn"
        data-url="{{ route('add.to.cart', $productDetail->slug) }}">
        <i class="fa fa-shopping-cart mr-1"></i> Add to Cart
    </a>
    <a href="{{ route('buy-now', $productDetail->slug) }}" class="btn-buy">
        <i class="fa fa-bolt mr-1"></i> Buy Now
    </a>
</div>
@else
<div class="mobile-sticky-bar d-lg-none">
    <a href="javascript:void(0)" class="btn-cart" style="opacity:0.5; cursor:not-allowed;">
        Out of Stock
    </a>
</div>
@endif
<!--================End Single Product Area =================-->

<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                    aria-selected="true">Specification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
                    aria-selected="false">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive">
                    {!! $productDetail->description !!}
                </div>
            </div>

            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Overall</h5>
                                    <h4>4.0</h4>
                                    <h6>(03 Reviews)</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rating_list">
                                    <h3>Based on 3 Reviews</h3>
                                    <ul class="list">
                                        <li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="review_list">
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{asset('assets/img/product/review-1.png')}}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{asset('assets/img/product/review-2.png')}}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{asset('assets/img/product/review-3.png')}}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Add a Review</h4>
                            <p>Your Rating:</p>
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p>Outstanding</p>
                            <form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Full name'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="number" name="number" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" rows="1" placeholder="Review" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Review'"></textarea></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" value="submit" class="primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Description Area =================-->

<!-- Start related-product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-title text-center mb-40">
                            <h2 class="font-weight-bold">More from this Category</h2>
                            <p>Discover other amazing products in the <strong>{{ $productDetail->category->name }}</strong> category.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse($relatedProducts as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="single-related-product d-flex align-items-center p-3 shadow-sm rounded bg-white product-card-hover">
                            <a href="{{ route('product-detail', $product->slug) }}" class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            </a>
                            <div class="desc ml-3">
                                <a href="{{ route('product-detail', $product->slug) }}" class="title font-weight-bold text-dark d-block mb-1" style="text-decoration: none; font-size: 15px;">
                                    {{ Str::limit($product->name, 25) }}
                                </a>
                                <div class="price">
                                    <h6 class="text-warning mb-0" style="font-size: 16px;">₹{{ $product->price }}</h6>
                                    @if($product->old_price)
                                    <span class="text-muted" style="text-decoration: line-through; font-size: 13px;">₹{{ $product->old_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-12">
                        <div class="no-products-wrapper text-center p-5 rounded">
                            <div class="icon-circle mb-3 mx-auto">
                                <span class="lnr lnr-cart text-muted" style="font-size: 50px; opacity: 0.5;"></span>
                            </div>
                            <h4 class="font-weight-bold text-dark">No Related Products Found</h4>
                            <p class="text-muted">We couldn't find any other products in this category right now.</p>
                            <a href="{{ route('trend-era-shop') }}" class="btn btn-warning px-4 py-2 mt-2 text-white font-weight-bold shadow-sm" style="border-radius: 25px;">
                                <span class="lnr lnr-arrow-left mr-2"></span>Back to Shop
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ctg-right shadow-sm rounded overflow-hidden h-100">
                    <a href="#" class="d-block h-100">
                        <img class="img-fluid w-100 h-100" src="{{asset('assets/img/category/c5.jpg')}}" alt="Side Banner" style="object-fit: cover;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        let url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    let badge = $('#cart-count-badge');

                    badge.text(response.cart_count);

                    if (response.cart_count > 0) {
                        badge.show();
                    } else {
                        badge.hide();
                    }

                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.log("Error Status:", xhr.status);
                console.error("Server Error Response:", xhr.responseText);

                let message = "કંઈક ભૂલ થઈ છે!";

                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        message = response.message;
                    }
                } catch (e) {
                    console.error("JSON Parse Error:", e);
                }

                if (xhr.status === 401) {
                    window.location.href = "{{ route('login-front') }}";
                } else if (xhr.status === 400) {
                    alert(message);
                } else {
                    alert("સર્વર એરર: " + xhr.status);
                }
            }
        });
    });
</script>
@endpush