@extends('layouts.frontendmaster')

@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Review</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Review</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-8 m-auto">
                    <div class="card">
                        <div class="card-header">
                            Give Review
                        </div>
                        <div class="card-body">
                            <form action="{{ route('customer.review.insert') }}" method="POST">
                                @csrf
                                @foreach ($invoice_details as $invoice_detail)
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-12 p-5 border">
                                                <h3>
                                                    {{ $invoice_detail->relationshiptoproduct->name }}
                                                </h3>
                                                <img src="{{ asset('uploads/product_thumbnails') }}/{{ $invoice_detail->relationshiptoproduct->product_thumbnail }}"
                                                    alt="not found">
                                            </div>
                                            @if (App\Models\Review::where('invoice_details_id', $invoice_detail->id)->exists())
                                                <div class="alert alert-warning">Review Already Given</div>
                                            @else
                                                <div class="col-4">
                                                    <label class="form-label">Rating (out of 5)</label>
                                                    <select name="rating[{{ $invoice_detail->id }}]" class="form-control">
                                                        <option value="">-Choose From Here-</option>
                                                        <option value="1">1 Star</option>
                                                        <option value="2">2 Stars</option>
                                                        <option value="3">3 Stars</option>
                                                        <option value="4">4 Stars</option>
                                                        <option value="5">5 Stars</option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <label class="form-label">Comments</label>
                                                    <input type="text" name="comments[{{ $invoice_detail->id }}]"
                                                        class="form-control">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn bg-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
