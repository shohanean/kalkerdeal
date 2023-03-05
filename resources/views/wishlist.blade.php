@extends('layouts.frontendmaster')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>Wishlist ({{ $wishlists->count() }})</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Wishlist Section Start -->
<section class="wishlist-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-3 g-2">
            @forelse ($wishlists as $wishlist)
                <div class="col-xxl-2 col-lg-3 col-md-4 col-6 product-box-contain">
                    <div class="product-box-3 h-100">
                        <div class="product-header">
                            <div class="product-image">
                                <a href="product-left-thumbnail.html">
                                    <img src="{{ asset('uploads/product_thumbnails') }}/{{ $wishlist->relationtoproduct->product_thumbnail }}" class="img-fluid blur-up lazyload" alt="">
                                </a>

                                <div class="product-header-top">
                                    <a href="{{ route('remove.from.wishlist', $wishlist->id) }}" class="btn wishlist-button close_button">
                                        <i data-feather="x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="product-footer">
                            <div class="product-detail">
                                <span class="span-name">{{ $wishlist->relationtoproduct->relationshipwithcategory->name }}</span>
                                <a href="product-left-thumbnail.html">
                                    <h5 class="name">{{ $wishlist->relationtoproduct->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 product-box-contain">
                    <div class="alert alert-danger">
                        Nothing to show here
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Wishlist Section End -->
@endsection
