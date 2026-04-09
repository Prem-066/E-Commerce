@extends('fronend.partials.app')
@section('title','Shop')
@section('contentt')
<style>
    /* ===== Shop Product Card Equal Height ===== */
    .product-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .single-product {
        display: flex;
        flex-direction: column;
    }

    .single-product .product-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .single-product .prd-bottom {
        margin-top: auto;
    }

    /* Remove underline from action links */
    .social-info,
    .social-info:hover,
    .social-info:focus {
        text-decoration: none !important;
    }

    .hover-text,
    .mobile-label {
        text-decoration: none !important;
    }

    /* Mobile short labels */
    .mobile-label {
        font-size: 0.65rem !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2;
    }

    @media (max-width: 1024px) {
        #mobileFilter {
            margin-bottom: 20px;
        }

        .product-details h6 {
            font-size: 13px;
        }
    }

    @media (max-width: 575px) {
        .product-card-img {
            height: 150px;
        }
    }
</style>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop Category page</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{route('trend-era-home')}}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{route('trend-era-shop')}}">Shop</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container mt-3">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4" id="mobileFilter">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    @foreach($categories as $cat)
                    <li class="main-nav-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('trend-era-shop', ['category' => $cat->id]) }}"
                                class="text-decoration-none {{ request('category') == $cat->id ? 'text-warning font-weight-bold' : '' }}">
                                <span class="lnr lnr-arrow-right"></span>{{$cat->name}}
                                <span class="number">({{ $cat->products_count ?? $cat->products->count() }})</span>
                            </a>

                            <a data-toggle="collapse" href="#cat{{$cat->id}}" aria-expanded="false" aria-controls="cat{{$cat->id}}" class="text-decoration-none">
                                <span class="lnr lnr-chevron-down" style="font-size: 12px; margin-left: 10px; cursor: pointer;"></span>
                            </a>
                        </div>

                        @php
                        $isSubSelected = false;
                        if(request()->has('subcategory')) {
                        $isSubSelected = $cat->subcategories->contains('id', request('subcategory'));
                        }
                        $shouldOpen = (request('category') == $cat->id || $isSubSelected);
                        @endphp

                        <ul class="collapse {{ $shouldOpen ? 'show' : '' }}" id="cat{{$cat->id}}">
                            @foreach($cat->subcategories as $subcat)
                            <li class="main-nav-list child">
                                <a href="{{ route('trend-era-shop', ['subcategory' => $subcat->id]) }}"
                                    class="text-decoration-none {{ request('subcategory') == $subcat->id ? 'text-warning font-weight-bold' : '' }}">
                                    {{$subcat->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Product Filters</div>
                <div class="common-filter">
                    <div class="head">Brands</div>
                    <form method="GET" action="{{ route('trend-era-shop') }}">

                        @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        @if(request('subcategory'))
                        <input type="hidden" name="subcategory" value="{{ request('subcategory') }}">
                        @endif

                        <ul class="row p-0 m-0">
                            @foreach($brands as $brand)
                            <li class="filter-list col-6" style="margin-bottom:8px; list-style:none;">

                                <input type="checkbox"
                                    name="brands[]"
                                    value="{{$brand->id}}"
                                    id="brand{{$brand->id}}"
                                    style="accent-color:#ffc107; margin-right:6px; cursor:pointer;"
                                    {{ in_array($brand->id, request()->brands ?? []) ? 'checked' : '' }}>

                                <label for="brand{{$brand->id}}" style="cursor:pointer; font-size:14px;">
                                    {{$brand->name}}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                        <button type="submit" class="btn btn-warning btn-sm mt-2">
                            Apply Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="mobile-filter-btn d-md-none mb-3">
            <button class="genric-btn primary radius w-100" onclick="toggleFilter()">
                Filters
            </button>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting mr-auto">
                    <p>Showing {{ $products->count() }} products</p>
                </div>
                <div class="pagination">
                </div>
                @if(request()->has('category') || request()->has('subcategory') || request()->has('brands'))
                <div class="mt-3">
                    <a href="{{ route('trend-era-shop') }}" class="genric-btn warning-border radius small text-black">Clear Filters</a>
                </div>
                @endif
            </div>

            <section class="lattest-product-area pb-40 category-list">
                <div class="row align-items-stretch">
                    @if($products->count() > 0)
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 col-6 mb-3 d-flex">
                        <div class="single-product h-100 w-100">
                            <img class="product-card-img" src="{{ asset('storage/'.$product->image) }}" alt="{{$product->name}}">

                            <div class="product-details">
                                <h6 style="font-size: 14px;">{{ Str::limit($product->name, 25) }}</h6>
                                <div class="price">
                                    <h6>₹{{ number_format($product->price, 2) }}</h6>
                                    @if($product->discount_price > $product->price)
                                    <h6 class="l-through">₹{{ number_format($product->discount_price) }}</h6>
                                    @endif
                                </div>
                                <div class="prd-bottom d-flex justify-content-start">
                                    @if($product->stock > 0)
                                    <a href="javascript:void(0)"
                                        class="social-info add-to-cart-btn d-flex align-items-center mr-2"
                                        data-url="{{ route('add.to.cart', $product->slug) }}">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text d-none d-md-block ml-1">add to bag</p>
                                        <p class="hover-text d-block d-md-none ml-1 mobile-label">Bag</p>
                                    </a>
                                    @endif
                                    @if($product->stock == 0)
                                    <a href="javascript:void(0)" class="social-info d-flex align-items-center mr-2">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text d-none d-md-block ml-1 text-danger">Out of Stock</p>
                                        <p class="hover-text d-block d-md-none ml-1 mobile-label text-danger">OOS</p>
                                    </a>
                                    @endif
                                    <a href="{{ route('wishlist.add', $product->id) }}" class="social-info d-flex align-items-center mr-2">
                                        <span class="lnr lnr-heart"></span>
                                        <p class="hover-text d-none d-md-block ml-1">Wishlist</p>
                                        <p class="hover-text d-block d-md-none ml-1 mobile-label">Fav.</p>
                                    </a>

                                    <a href="{{ route('product-detail', $product->slug) }}" class="social-info d-flex align-items-center">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text ml-1">view</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No products found for "{{ $query }}"</h4>
                        <a href="{{ route('trend-era-shop') }}" class="btn btn-primary mt-3">View All Products</a>
                    </div>
                    @endif
                </div>
                <!-- <div class="mt-4">
                    {{ $products->appends(['query' => $query])->links() }}
                </div> -->

                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting mr-auto">
                        <select onchange="location = this.value;" class="nice-select-custom">
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 9]) }}" {{ request('per_page') == 9 ? 'selected' : '' }}>Show 9</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 12]) }}" {{ request('per_page') == 12 ? 'selected' : '' }}>Show 12</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 24]) }}" {{ request('per_page') == 24 ? 'selected' : '' }}>Show 24</option>
                        </select>
                    </div>

                    <div class="pagination">
                        @if ($products->onFirstPage())
                        <a href="javascript:void(0)" class="prev-arrow disabled"><i class="bi bi-arrow-left" aria-hidden="true"></i></a>
                        @else
                        <a href="{{ $products->previousPageUrl() }}" class="prev-arrow"><i class="bi bi-arrow-left" aria-hidden="true"></i></a>
                        @endif

                        @foreach ($products->render()->elements as $element)
                        @if (is_string($element))
                        <a href="javascript:void(0)" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                        @endif

                        @if (is_array($element))
                        @foreach ($element as $page => $url)
                        @if ($page == $products->currentPage())
                        <a href="javascript:void(0)" class="active">{{ $page }}</a>
                        @else
                        <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="next-arrow"><i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <a href="javascript:void(0)" class="next-arrow disabled"><i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<section class="related-product-area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Deals of the Week</h1>
                    <p>Buy today with lowest price</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @foreach($deals as $item)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex ">
                            <a href="{{ route('product-detail', $item->slug) }}">
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" style="width: 70px; height: 70px; object-fit: cover;">
                            </a>
                            <div class="desc ">
                                <a href="{{ route('product-detail', $item->slug) }}" class="title text-decoration-none">
                                    {{ Str::limit($item->name, 20) }}
                                </a>
                                <div class="price">
                                    <h6>${{ $item->price }}</h6>
                                    @if($item->old_price)
                                    <h6 class="l-through">${{ $item->old_price }}</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{ asset('assets/img/category/c5.jpg') }}" alt="Ad Banner">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    @media (max-width: 768px) {
        .product-details h6 {
            font-size: 14px;
        }

        .col-xl-3.col-lg-4.col-md-5 {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        .col-xl-9.col-lg-8.col-md-7 {
            width: 100%;
            max-width: 100%;
        }

        .sidebar-categories,
        .sidebar-filter {
            padding: 10px;
        }

        #mobileFilter {
            display: none;
            background: #fff;
            padding: 15px;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        #mobileFilter.show {
            display: block;
        }
    }
</style>
@push('scripts')
<script>
    function toggleFilter() {
        document.getElementById("mobileFilter").classList.toggle("show");
    }
</script>
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
@endsection