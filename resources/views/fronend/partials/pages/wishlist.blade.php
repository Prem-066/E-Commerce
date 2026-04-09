@extends('fronend.partials.app')
@section('title','My Wishlist')
@section('contentt')

<style>
    .wishlist-container {
        padding: 80px 0;
        background: #f9f9ff;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        border: none;
    }

    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 250px;
    }

    .product-img-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .wishlist-card:hover .product-img-wrapper img {
        transform: scale(1.1);
    }

    .wishlist-content {
        padding: 25px;
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
        display: block;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    .product-desc {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-price {
        font-size: 20px;
        font-weight: 700;
        color: #ffba00;
        margin-bottom: 15px;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .btn-cart {
        background: linear-gradient(90deg, #ffba00 0%, #ff6c00 100%);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }

    .btn-cart:hover {
        background: linear-gradient(90deg, #ff6c00 0%, #ffba00 100%);
        color: #fff;
        box-shadow: 0 5px 15px rgba(255, 186, 0, 0.4);
    }

    .btn-remove {
        background: transparent;
        color: #ff4d4d;
        border: 1px solid #ff4d4d;
        padding: 8px 15px;
        border-radius: 25px;
        font-size: 13px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #ff4d4d;
        color: #fff;
    }

    .empty-wishlist {
        text-align: center;
        padding: 100px 0;
    }

    .empty-wishlist i {
        font-size: 80px;
        color: #ddd;
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        .wishlist-container {
            padding: 40px 0;
            /* મોબાઈલમાં ઓછી જગ્યા */
        }

        .product-img-wrapper {
            height: 160px;
            /* મોબાઈલ માટે નાની ઈમેજ હાઇટ */
        }

        .wishlist-content {
            padding: 12px;
            /* પેડિંગ ઓછું કર્યું */
        }

        .product-name {
            font-size: 14px;
            /* નામ નાનું કર્યું */
            margin-bottom: 5px;
        }

        .product-desc {
            display: none;
            /* મોબાઈલમાં ડિસ્ક્રિપ્શન કાઢી નાખવું સારું રહેશે જેથી લુક ક્લીન રહે */
        }

        .product-price {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn-cart,
        .btn-remove {
            padding: 6px 10px;
            font-size: 11px;
            /* બટન ટેક્સ્ટ નાનો કર્યો */
            border-radius: 15px;
        }

        .status-badge {
            padding: 3px 8px;
            font-size: 10px;
            top: 8px !important;
            right: 8px !important;
        }

        /* કાર્ડ વચ્ચેની ગેપ ઓછી કરવા માટે */
        .px-2 {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
    }
</style>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>My Wishlist</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('trend-era-home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Wishlist</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- End Banner Area -->

<section class="wishlist-container">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="mb-2">Items You Loved</h2>
            <p>Your saved favorites are waiting for you.</p>
        </div>

        <div class="row">
            @forelse($wishlistItems as $item)
            <div class="col-lg-4 col-md-6 col-6 px-2 px-md-3">
                <div class="wishlist-card">
                    <div class="product-img-wrapper">
                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}">
                        <div style="position: absolute; top: 15px; right: 15px;">
                            @if($item->product->stock > 0)
                            <span class="status-badge bg-success text-white">In Stock</span>
                            @else
                            <span class="status-badge bg-danger text-white">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    <div class="wishlist-content">
                        <a href="{{ route('product-detail', $item->product->slug) }}" style="text-decoration: none;" class="product-name" title="{{ $item->product->name }}">
                            {{ $item->product->name }}
                        </a>
                        <p class="product-desc">
                            {!! \Str::limit(strip_tags($item->product->description), 100) !!}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="product-price">₹{{ number_format($item->product->price, 2) }}</h4>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('add.to.cart', $item->product->slug) }}" style="text-decoration: none;" class="btn-cart d-flex align-items-center justify-content-center">
                                <i class="fa fa-shopping-cart mr-2"></i> Add to Cart
                            </a>

                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove d-flex align-items-center justify-content-center" onclick="return confirm('Remove this item from your wishlist?')">
                                    <i class="fa fa-trash-alt mr-2"></i> Remove Item
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-wishlist">
                    <i class="fa fa-heart-broken"></i>
                    <h3>Your wishlist is feeling lonely!</h3>
                    <p class="text-muted mb-4">You haven't added any products to your wishlist yet.</p>
                    <a href="{{ route('trend-era-shop') }}" class="primary-btn">Explore Shop</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection