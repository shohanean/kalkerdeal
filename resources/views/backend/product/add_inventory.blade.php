@extends('layouts.dashboardmaster')

@section('content')
<div class="page-body">
    <!-- New Product Add Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8 m-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-10">
                                        <h5>
                                            Add Inventory of {{ $product->name }}
                                        </h5>
                                    </div>
                                    <div class="col-2">
                                        <a class="btn btn-sm btn-warning" target="_blank" href="{{ route('product.details', $product->id) }}">View Product</a>
                                    </div>
                                </div>



                                <hr>
                                <p>Product Short Description: {{ $product->short_description }}</p>
                                <img src="{{ asset('uploads/product_thumbnails') }}/{{ $product->product_thumbnail }}" alt="not found">
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-warning">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-secondary">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('insert.inventory', $product->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Size Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="size_id">
                                                <option value="">-Select One Size-</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Color Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="color_id">
                                                <option value="">-Select One Color-</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Quantity <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" placeholder="Quantity" name="quantity">
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add Inventory</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>Inventory Calculation</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Size Name</th>
                                            <th scope="col">Color Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Value (BDT)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_value = 0;
                                        @endphp
                                        @foreach ($inventories as $inventory)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>
                                                    {{ $inventory->relationshiptosize->name }}
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: {{ $inventory->relationshiptocolor->code }}">
                                                        &nbsp;
                                                    </span>
                                                    {{ $inventory->relationshiptocolor->name }}
                                                </td>
                                                <td>{{ $inventory->quantity }}</td>
                                                <td>
                                                    {{ $inventory->quantity * $product->purchase_manufacturing_price }}
                                                    @php
                                                        $total_value += ($inventory->quantity * $product->purchase_manufacturing_price);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3">
                                                <b>Total</b>
                                            </td>
                                            <td>
                                                <b>{{ $inventories->sum('quantity') }}</b>
                                            </td>
                                            <td>
                                                <b>{{ $total_value }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Product Add End -->

    @include('parts.copyright')
    </div>
@endsection
