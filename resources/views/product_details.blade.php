@extends('layouts.frontendmaster')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Enter your credentials to login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('custom.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button style="background: rgb(0, 166, 255)" type="submit"
                            class="btn btn-sm btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ $product->name }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                @if (session('login_error'))
                    <div class="alert alert-danger">
                        {{ session('login_error') }}
                    </div>
                @endif
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-2">
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                        <div class="product-main-2 no-arrow">
                                            @foreach ($featured_photos as $featured_photo)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ asset('uploads/product_featured_photos') }}/{{ $featured_photo->featured_photo_name }}"
                                                            data-zoom-image="{{ asset('uploads/product_featured_photos') }}/{{ $featured_photo->featured_photo_name }}"
                                                            class="img-fluid image_zoom_cls-0 blur-up lazyload"
                                                            alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                        <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                            @foreach ($featured_photos as $featured_photo)
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="{{ asset('uploads/product_featured_photos') }}/{{ $featured_photo->featured_photo_name }}"
                                                            class="img-fluid blur-up lazyload" alt="not found">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                @if ($product->discount > 0)
                                    <h6 class="offer-top">{{ $product->discount }}% Off</h6>
                                @endif
                                <h2 class="name">{{ $product->name }}</h2>
                                <div class="price-rating">
                                    <h3 class="theme-color price">
                                        {{ $product->discounted_price }}
                                        @if ($product->discount > 0)
                                            <del class="text-content">{{ $product->regular_price }}</del>
                                            <span class="offer theme-color">({{ $product->discount }}% off)</span>
                                        @endif
                                    </h3>
                                    <div class="product-rating custom-rate">
                                        <ul class="rating">
                                            @for ($i = 1; $i <= round($reviews->avg('rating')); $i++)
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                            @endfor
                                        </ul>
                                        <span class="review">{{ count($reviews) }} Customer Reviews</span>
                                    </div>
                                </div>

                                <div class="procuct-contain">
                                    <p>
                                        {{ $product->short_description }}
                                    </p>
                                </div>

                                <div class="product-packege ">
                                    <div class="product-title">
                                        <h4>Size</h4>
                                    </div>
                                    <select id="size_dropdown" name="" class="form-control">
                                        <option value="">-Select One Size-</option>
                                        @foreach ($inventories->unique('size_id') as $inventory)
                                            <option value="{{ $inventory->relationshiptosize->id }}">
                                                {{ $inventory->relationshiptosize->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="product-title">
                                        <h4>Color</h4>
                                    </div>
                                    <select name="" class="form-control" id="color_dropdown">
                                        <option value="">-Choose Size First-</option>
                                    </select>
                                </div>
                                <div class="note-box product-packege">
                                    <div class="cart_qty qty-box product-qty">
                                        <div class="input-group">
                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                name="quantity" value="1">
                                            <button type="button" class="qty-left-minus" data-type="minus"
                                                data-field="">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @auth
                                        <button id="add_to_cart_btn"
                                            class="btn btn-md bg-dark cart-button text-white w-100 d-none">
                                            Add To Cart
                                        </button>
                                    @else
                                        <button class="btn btn-md bg-danger cart-button text-white w-100"
                                            data-bs-toggle="modal" data-bs-target="#loginModal">
                                            Login First
                                        </button>
                                    @endauth

                                </div>
                                <div class="d-none">
                                    <p>Size ID: <span id="d_size_id"></span></p>
                                    <p>Color ID: <span id="d_color_id"></span></p>
                                    <p>Product ID: <span id="d_product_id">{{ $product->id }}</span></p>
                                </div>
                                @auth
                                    <div class="buy-box">
                                        @if (App\Models\Wishlist::where(['user_id' => auth()->id(), 'product_id' => $product->id])->exists())
                                            <i class="fa fa-heart text-danger"></i>
                                            <span>Already added to Wishlist</span>
                                        @else
                                            <a href="{{ route('add.to.wishlist', $product->id) }}">
                                                <i class="fa fa-heart-o"></i>
                                                <span>Add To Wishlist</span>
                                            </a>
                                        @endif

                                    </div>
                                @endauth

                                <div class="pickup-box">

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Category : <a
                                                    href="javascript:void(0)">{{ $product->relationshipwithcategory->name }}</a>
                                            </li>
                                            <li>Selling Since : <a
                                                    href="javascript:void(0)">{{ $product->created_at->format('M d, Y') }}</a>
                                            </li>
                                            <li>Stock : <a
                                                    href="javascript:void(0)">{{ $inventories->sum('quantity') }}</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="paymnet-option">
                                    <div class="product-title">
                                        <h4>Guaranteed Safe Checkout</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/product/payment/1.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/product/payment/2.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/product/payment/3.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/product/payment/4.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/product/payment/5.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="product-section-box">
                                <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                            data-bs-target="#description" type="button" role="tab"
                                            aria-controls="description" aria-selected="true">Description</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="info-tab" data-bs-toggle="tab"
                                            data-bs-target="#info" type="button" role="tab" aria-controls="info"
                                            aria-selected="false">Additional info</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="care-tab" data-bs-toggle="tab"
                                            data-bs-target="#care" type="button" role="tab" aria-controls="care"
                                            aria-selected="false">Care Instuctions</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                            data-bs-target="#review" type="button" role="tab"
                                            aria-controls="review" aria-selected="false">Review</button>
                                    </li>
                                </ul>

                                <div class="tab-content custom-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                                        aria-labelledby="description-tab">
                                        <div class="product-description">
                                            <div class="nav-desh">
                                                <p>
                                                    {{ $product->long_description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="info" role="tabpanel"
                                        aria-labelledby="info-tab">
                                        {{ $product->additional_information }}
                                    </div>

                                    <div class="tab-pane fade" id="care" role="tabpanel"
                                        aria-labelledby="care-tab">
                                        {{ $product->care_instructions }}
                                    </div>

                                    <div class="tab-pane fade" id="review" role="tabpanel"
                                        aria-labelledby="review-tab">
                                        <div class="review-box">
                                            <div class="row g-4">
                                                <div class="col-xl-6">
                                                    <div class="review-title">
                                                        <h4 class="fw-500">Customer reviews</h4>
                                                    </div>

                                                    <div class="d-flex">
                                                        <div class="product-rating">
                                                            <ul class="rating">
                                                                <li>
                                                                    <i data-feather="star" class="fill"></i>
                                                                </li>
                                                                <li>
                                                                    <i data-feather="star" class="fill"></i>
                                                                </li>
                                                                <li>
                                                                    <i data-feather="star" class="fill"></i>
                                                                </li>
                                                                <li>
                                                                    <i data-feather="star"></i>
                                                                </li>
                                                                <li>
                                                                    <i data-feather="star"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <h6 class="ms-3">4.2 Out Of 5</h6>
                                                    </div>

                                                    <div class="rating-box">
                                                        <ul>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h5>5 Star</h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 68%" aria-valuenow="100"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            68%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="rating-list">
                                                                    <h5>4 Star</h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 67%" aria-valuenow="100"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            67%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="rating-list">
                                                                    <h5>3 Star</h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 42%" aria-valuenow="100"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            42%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="rating-list">
                                                                    <h5>2 Star</h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 30%" aria-valuenow="100"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            30%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="rating-list">
                                                                    <h5>1 Star</h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 24%" aria-valuenow="100"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            24%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="review-title">
                                                        <h4 class="fw-500">Add a review</h4>
                                                    </div>

                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <div class="form-floating theme-form-floating">
                                                                <input type="text" class="form-control" id="name"
                                                                    placeholder="Name">
                                                                <label for="name">Your Name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating theme-form-floating">
                                                                <input type="email" class="form-control" id="email"
                                                                    placeholder="Email Address">
                                                                <label for="email">Email Address</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating theme-form-floating">
                                                                <input type="url" class="form-control" id="website"
                                                                    placeholder="Website">
                                                                <label for="website">Website</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating theme-form-floating">
                                                                <input type="url" class="form-control" id="review1"
                                                                    placeholder="Give your review a title">
                                                                <label for="review1">Review Title</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-floating theme-form-floating">
                                                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px"></textarea>
                                                                <label for="floatingTextarea2">Write Your
                                                                    Comment</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="review-title">
                                                        <h4 class="fw-500">Customer Reviews</h4>
                                                    </div>

                                                    <div class="review-people">
                                                        <ul class="review-list">
                                                            @foreach ($reviews as $review)
                                                                <li>
                                                                    <div class="people-box">
                                                                        <div>
                                                                            <div class="people-image">
                                                                                <img src="{{ asset('frontend_assets') }}/assets/images/review/1.jpg"
                                                                                    class="img-fluid blur-up lazyload"
                                                                                    alt="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="people-comment">
                                                                            <div class="badge bg-success">
                                                                                {{ $review->relationshiptouser->name }}
                                                                            </div>
                                                                            <div class="date-time">
                                                                                <h6 class="text-content">
                                                                                    {{ $review->created_at->diffForHumans() }}
                                                                                </h6>

                                                                                <div class="product-rating">
                                                                                    <ul class="rating">
                                                                                        @for ($i = 1; $i <= $review->rating; $i++)
                                                                                            <li>
                                                                                                <i data-feather="star"
                                                                                                    class="fill"></i>
                                                                                            </li>
                                                                                        @endfor
                                                                                        {{-- <li>
                                                                                            <i data-feather="star"></i>
                                                                                        </li> --}}
                                                                                    </ul>
                                                                                </div>
                                                                            </div>

                                                                            <div class="reply">
                                                                                <p>
                                                                                    {{ $review->comments }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        <div class="vendor-box">
                            <div class="verndor-contain">
                                <div class="vendor-image">
                                    <img src="{{ asset('uploads/profile_photos') }}/{{ $vendor->profile_photo }}"
                                        class="blur-up lazyload" alt="not found">
                                </div>

                                <div class="vendor-name">
                                    <h5 class="fw-500">{{ $vendor->name }}</h5>

                                    <div class="product-rating mt-1">
                                        <ul class="rating">
                                            @for ($i = 1; $i <= round($vendor_reviews->avg('rating')); $i++)
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                            @endfor
                                        </ul>
                                        <span>({{ count($vendor_reviews) }} Reviews)</span>
                                    </div>

                                </div>
                            </div>

                            <div class="vendor-list">
                                <ul>
                                    <li>
                                        <div class="address-contact">
                                            <i data-feather="mail"></i>
                                            <h5>Email: <span class="text-content">{{ $vendor->email }}</span></h5>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="address-contact">
                                            <i data-feather="clock"></i>
                                            <h5>Member Since: <span
                                                    class="text-content">{{ $vendor->created_at->format('d M, Y') }}</span>
                                            </h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Trending Product -->
                        <div class="pt-25">
                            <div class="category-menu">
                                <h3>Trending Products</h3>

                                <ul class="product-list product-right-sidebar border-0 p-0">
                                    <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/vegetable/product/23.png"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Meatigo Premium Goat Curry</h6>
                                                    </a>
                                                    <span>450 G</span>
                                                    <h6 class="price theme-color">$ 70.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/vegetable/product/24.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Dates Medjoul Premium Imported</h6>
                                                    </a>
                                                    <span>450 G</span>
                                                    <h6 class="price theme-color">$ 40.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/vegetable/product/25.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Good Life Walnut Kernels</h6>
                                                    </a>
                                                    <span>200 G</span>
                                                    <h6 class="price theme-color">$ 52.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="mb-0">
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="{{ asset('frontend_assets') }}/assets/images/vegetable/product/26.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Apple Red Premium Imported</h6>
                                                    </a>
                                                    <span>1 KG</span>
                                                    <h6 class="price theme-color">$ 80.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Banner Section -->
                        <div class="ratio_156 pt-25">
                            <div class="home-contain">
                                <img src="{{ asset('frontend_assets') }}/assets/images/vegetable/banner/8.jpg"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner">Seafood</h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold">Freshes</span> Products</h3>
                                        <h3 class="fw-light">every hour</h3>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md fw-bold mend-auto">Shop Now <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    <!-- Releted Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Related Products ({{ $related_products->count() }})</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('frontend_assets') }}/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-6_1 product-wrapper">
                        @forelse ($related_products as $related_product)
                            <div>
                                <div class="product-box-3 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="product-left.htm">
                                                <img src="{{ asset('uploads/product_thumbnails') }}/{{ $related_product->product_thumbnail }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>

                                            <ul class="product-option">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#view">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                                    <a href="compare.html">
                                                        <i data-feather="refresh-cw"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                    <a href="wishlist.html" class="notifi-wishlist">
                                                        <i data-feather="heart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">
                                                {{ $related_product->relationshipwithcategory->name }}
                                            </span>
                                            <a href="{{ route('product.details', $related_product->id) }}">
                                                <h5 class="name">{{ $related_product->name }}</h5>
                                            </a>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    <li>
                                                        <i data-feather="star" class="fill"></i>
                                                    </li>
                                                    <li>
                                                        <i data-feather="star" class="fill"></i>
                                                    </li>
                                                    <li>
                                                        <i data-feather="star" class="fill"></i>
                                                    </li>
                                                    <li>
                                                        <i data-feather="star" class="fill"></i>
                                                    </li>
                                                    <li>
                                                        <i data-feather="star" class="fill"></i>
                                                    </li>
                                                </ul>
                                                <span>(5.0)</span>
                                            </div>
                                            <h5 class="price"><span
                                                    class="theme-color">{{ $related_product->discounted_price }}</span>
                                                @if ($related_product->discount > 0)
                                                    <del>{{ $related_product->regular_price }}</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <a href="{{ route('product.details', $related_product->id) }}"
                                                    class="btn btn-add-cart addcart-button">
                                                    Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                No Related Products to Show
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Releted Product Section End -->
@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function() {
            $('#size_dropdown').change(function() {
                $('#add_to_cart_btn').addClass('d-none');
                var size_id = $(this).val();
                $('#d_size_id').html(size_id);
                var product_id = "{{ $product->id }}";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/get/color/list',
                    data: {
                        size_id: size_id,
                        product_id: product_id
                    },
                    success: function(data) {
                        $('#color_dropdown').html(data);
                    }
                });
            });
            $('#color_dropdown').change(function() {
                var color_dropdown_value = $(this).val();
                $('#d_color_id').html(color_dropdown_value);
                if (color_dropdown_value) {
                    $('#add_to_cart_btn').removeClass('d-none');
                } else {
                    $('#add_to_cart_btn').addClass('d-none');
                }
            });
            $('#add_to_cart_btn').click(function() {
                var user_quantity = $('.qty-input').val();
                var d_size_id = $('#d_size_id').html();
                var d_color_id = $('#d_color_id').html();
                var d_product_id = $('#d_product_id').html();
                // alert(user_quantity);
                // alert(d_size_id);
                // alert(d_color_id);
                // alert(d_product_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/add/to/cart',
                    data: {
                        user_quantity: user_quantity,
                        d_size_id: d_size_id,
                        d_color_id: d_color_id,
                        d_product_id: d_product_id
                    },
                    success: function(data) {
                        if (data == 'success') {
                            location.reload();
                        } else {
                            alert(data);
                        }
                    }
                });
            });
        });
    </script>
@endsection
