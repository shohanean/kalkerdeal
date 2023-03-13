@extends('layouts.frontendmaster')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>Cart</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-9">
                <style>
                    .halka_red{
                        background: rgb(244, 195, 195)
                    }
                </style>
                <div class="cart-table">
                    <div class="table-responsive-xl">
                        <table class="table">
                            <tbody>
                                @php
                                    $cart_total = 0;
                                    $save_total = 0;
                                    $error = false;
                                @endphp
                                <form action="{{ route('update.cart') }}" method="POST">
                                    @csrf
                                @forelse (carts() as $cart)
                                @php
                                    if(stock($cart->product_id, $cart->color_id, $cart->size_id) < $cart->amount){
                                        $error = true;
                                    }
                                @endphp
                                <tr class="product-box-contain @if(stock($cart->product_id, $cart->color_id, $cart->size_id) < $cart->amount) halka_red @endif">
                                    <td class="product-detail">
                                        <div class="product border-0">
                                            <a href="product-left-thumbnail.html" class="product-image">
                                                <img src="{{ asset('uploads/product_thumbnails') }}/{{ $cart->relationshiptoproduct->product_thumbnail }}" class="img-fluid blur-up lazyload" alt="not found">
                                            </a>
                                            <div class="product-detail">
                                                <ul>
                                                    <li class="name">
                                                        <a href="product-left-thumbnail.html">
                                                            {{ $cart->relationshiptoproduct->name }}
                                                            <small>({{ $cart->relationshiptoproduct->relationshipwithuser->name }})</small>
                                                        </a>
                                                    </li>

                                                    <li class="text-content">
                                                        <span class="text-title">Color</span> {{ $cart->relationshiptocolor->name }}
                                                        <span class="text-title">Size</span> {{ $cart->relationshiptosize->name }}
                                                        <br>
                                                        <span class="badge bg-warning">Stock: {{ stock($cart->product_id, $cart->color_id, $cart->size_id) }}</span>
                                                    </li>

                                                    {{--<li>
                                                        <h5 class="text-content d-inline-block">Price :</h5>
                                                        <span>$35.10</span>
                                                        <span class="text-content">$45.68</span>
                                                    </li>

                                                    <li>
                                                        <h5 class="saving theme-color">Saving : $20.68</h5>
                                                    </li>

                                                    <li class="quantity">
                                                        <div class="quantity-price">
                                                            <div class="cart_qty">
                                                                <div class="input-group">
                                                                    <button type="button" class="btn qty-left-minus"
                                                                        data-type="minus" data-field="">
                                                                        <i class="fa fa-minus ms-0"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                    <input
                                                                        class="form-control input-number qty-input"
                                                                        type="text" name="quantity" value="0">
                                                                    <button type="button" class="btn qty-right-plus"
                                                                        data-type="plus" data-field="">
                                                                        <i class="fa fa-plus ms-0"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <h5>Total: $67.36</h5>
                                                    </li>--}}
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="price">
                                        <h4 class="table-title text-content">Price</h4>
                                        @if ($cart->relationshiptoproduct->discount > 0 )
                                            <h5>{{ $cart->relationshiptoproduct->discounted_price }} <del class="text-content">{{ $cart->relationshiptoproduct->regular_price }}</del></h5>
                                            <h6 class="theme-color">You Save : {{ $cart->relationshiptoproduct->regular_price - $cart->relationshiptoproduct->discounted_price }}</h6>
                                            @php
                                                $save_total += ($cart->relationshiptoproduct->regular_price - $cart->relationshiptoproduct->discounted_price);
                                            @endphp
                                        @else
                                        {{ $cart->relationshiptoproduct->discounted_price }}
                                        @endif
                                    </td>

                                    <td class="quantity">
                                        <h4 class="table-title text-content">Qty</h4>
                                        <div class="quantity-price">
                                            <div class="cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus"
                                                        data-type="minus" data-field="">
                                                        <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity[{{ $cart->id }}]" value="{{ $cart->amount }}">
                                                    <button type="button" class="btn qty-right-plus"
                                                        data-type="plus" data-field="">
                                                        <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="subtotal">
                                        <h4 class="table-title text-content">Total</h4>
                                        <h5>{{ $cart->relationshiptoproduct->discounted_price * $cart->amount }}</h5>
                                        @php
                                            $cart_total += ($cart->relationshiptoproduct->discounted_price * $cart->amount);
                                        @endphp
                                    </td>

                                    <td class="save-remove">
                                        <h4 class="table-title text-content">Action</h4>
                                        <a class="remove close_button" href="{{ route('remove.from.cart', $cart->id) }}">Remove</a>
                                    </td>
                                </tr>
                                @empty
                                <div class="alert alert-danger">
                                    Nothing to show
                                </div>
                                @endforelse
                                @if (carts()->count() > 0)
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <button type="submit" class="btn btn-sm bg-info text-white fw-bold">Update Cart</button>
                                    </td>
                                </tr>
                                @endif
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <div class="summery-contain">
                        <div class="coupon-cart">
                            <h6 class="text-content mb-2">Coupon Apply</h6>
                            <form action="" method="GET">
                                <div class="mb-3 coupon-box input-group">
                                    <input type="text" class="form-control" placeholder="Enter Coupon Code Here..." name="coupon_name" value="{{ $coupon_name }}">
                                    <button type="submit" class="btn-apply">Apply</button>
                                </div>
                            </form>
                            @if (session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                            @endif
                        </div>
                        <ul>
                            <li>
                                <h4>Total Save</h4>
                                <h4 class="price">{{ $save_total }}</h4>
                            </li>
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price">{{ ceil($cart_total) }}</h4>
                            </li>
                            <li class="align-items-start">
                                <h4>Coupon Discount (%)</h4>
                                <h4 class="price text-end">{{ $discount }}%</h4>
                            </li>
                            <li class="align-items-start">
                                <h4>Coupon Discount (-)</h4>
                                <h4 class="price text-end">{{ floor(($discount/100)*$cart_total) }}</h4>
                            </li>
                            @php
                                session(['s_coupon_name' => $coupon_name]);
                                session(['s_subtotal' => ceil($cart_total)]);
                                session(['s_coupon_discount_percent' => $discount]);
                                session(['s_coupon_discount_amount' => floor((($discount/100)*$cart_total)) ]);
                                session(['s_total' => (ceil($cart_total) - floor((($discount/100)*$cart_total)))]);
                            @endphp
                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Total</h4>
                            <h4 class="price theme-color">{{ ceil($cart_total) - floor((($discount/100)*$cart_total)) }}</h4>
                        </li>
                    </ul>

                    <div class="button-group cart-button">
                        <ul>
                            @if ($error)
                            <div class="alert alert-danger">
                                Please solve all stock related issue to proceed further
                            </div>
                            @else
                            <li>
                                <button onclick="location.href = '{{ route('checkout') }}'"
                                    class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                            </li>
                            @endif

                            <li>
                                <button onclick="location.href = '{{ route('shop', 'all') }}'"
                                    class="btn btn-light shopping-button text-dark">
                                    <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Cart Section End -->
@endsection
