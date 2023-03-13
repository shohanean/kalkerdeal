@extends('layouts.frontendmaster')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>Checkout</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Add new address Modal start-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('add.address') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Label</label>
                <input type="text" class="form-control" name="label">
            </div>
            <div class="mb-3">
                <label class="form-label">Customer Name</label>
                <input type="text" class="form-control" name="customer_name">
            </div>
            <div class="mb-3">
                <label class="form-label">Full Address</label>
                <textarea name="full_address" class="form-control"rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Zip Code</label>
                <input type="text" class="form-control" name="zip_code">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number">
            </div>
            <button style="background: rgb(0, 166, 255)" type="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add new address Modal start-->

<!-- Checkout section Start -->
<section class="checkout-section-2 section-b-space">
    <div class="container-fluid-lg">
        <form action="{{ route('checkout.final') }}" method="POST">
            @csrf
            <div class="row g-sm-4 g-3">
                <div class="col-lg-8">
                    <div class="left-sidebar-checkout">
                        <div class="checkout-detail-box">
                            <ul>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                            trigger="loop-on-hover"
                                            colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a"
                                            class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Delivery Address</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="row g-4">
                                                @foreach ($addresses as $address)
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="delivery-address-box">
                                                            <div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="address_id"
                                                                        id="flexRadioDefault1" {{ ($loop->index == 0) ? "checked" : "" }} value="{{ $address->id }}">
                                                                </div>

                                                                <div class="label">
                                                                    <label>{{ $address->label }}</label>
                                                                </div>

                                                                <ul class="delivery-address-detail">
                                                                    <li>
                                                                        <h4 class="fw-500">{{ $address->customer_name }}</h4>
                                                                    </li>

                                                                    <li>
                                                                        <p class="text-content"><span
                                                                                class="text-title">Address
                                                                                : </span>{{ $address->full_address }}</p>
                                                                    </li>

                                                                    <li>
                                                                        <h6 class="text-content"><span
                                                                                class="text-title">Zip Code
                                                                                :</span> {{ $address->zip_code }}</h6>
                                                                    </li>

                                                                    <li>
                                                                        <h6 class="text-content mb-0"><span
                                                                                class="text-title">Phone
                                                                                :</span> {{ $address->phone_number }}</h6>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-xxl-12 col-lg-12 col-md-12">
                                                    <div class="delivery-address-box text-center">
                                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            <h4><i class="fa fa-plus-circle"></i> Add New Address</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/oaflahpk.json"
                                            trigger="loop-on-hover" colors="primary:#0baf9a" class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Delivery Option</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="row g-4">
                                                <div class="col-xxl-6">
                                                    <div class="delivery-option">
                                                        <div class="delivery-category">
                                                            <div class="shipment-detail">
                                                                <div
                                                                    class="form-check custom-form-check hide-check-box">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="delivery_option" id="standard" checked value="1">
                                                                    <label class="form-check-label"
                                                                        for="standard">Inside Dhaka (+60 tk)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-6">
                                                    <div class="delivery-option">
                                                        <div class="delivery-category">
                                                            <div class="shipment-detail">
                                                                <div
                                                                    class="form-check mb-0 custom-form-check show-box-checked">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="delivery_option" id="future" value="2">
                                                                    <label class="form-check-label" for="future">Outside Dhaka (+120 tk)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                            trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                            class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Payment Option</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingFour">
                                                        <div class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseFour">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="cash"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="payment_option" id="cash" checked value="cod"> Cash
                                                                    On Delivery (COD)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseFour"
                                                        class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <p class="cod-review">
                                                                Pay after you get the product at your doorsteps
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingOne">
                                                        <div class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseOne">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="credit"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="payment_option" id="credit" value="online">
                                                                    Online Payment (Card, MFS)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <p class="cod-review">Pay digitally with cards and mfs
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="right-side-summery-box">
                        <div class="summery-box-2">
                            <div class="summery-header">
                                <h3>Order Summery</h3>
                            </div>

                            <ul class="summery-contain">
                                @foreach (carts() as $cart)
                                <li>
                                    <img src="{{ asset('uploads/product_thumbnails') }}/{{ $cart->relationshiptoproduct->product_thumbnail }}"
                                        class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>{{ $cart->relationshiptoproduct->name }} <span>X {{ $cart->amount }}</span></h4>
                                    <h4 class="price">{{ $cart->amount * $cart->relationshiptoproduct->discounted_price }}</h4>
                                </li>
                                @endforeach
                            </ul>

                            <ul class="summery-total">
                                <li>
                                    <h4>Coupon Name</h4>
                                    <h4 class="price">{{ session('s_coupon_name') ? session('s_coupon_name'):'-' }}</h4>
                                </li>
                                <li>
                                    <h4>Coupon Discount (%)</h4>
                                    <h4 class="price">{{ session('s_coupon_discount_percent') }}%</h4>
                                </li>
                                <li>
                                    <h4>Coupon Discount (-)</h4>
                                    <h4 class="price">{{ session('s_coupon_discount_amount') }}</h4>
                                </li>
                                <li>
                                    <h4>Subtotal</h4>
                                    <h4 class="price">{{ session('s_subtotal') }}</h4>
                                </li>

                                <li class="list-total">
                                    <h4>Total</h4>
                                    <h4 class="price">{{ session('s_total') }}</h4>
                                </li>
                            </ul>
                        </div>
                        <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout section End -->
@endsection
