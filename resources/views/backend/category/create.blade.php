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
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Category Information</h5>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-warning">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ url('category/insert') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Category Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Category Name" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Category Description <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Category Thumbnail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="category_thumbnail">
                                        </div>
                                    </div>
                                    {{-- <div class="mb-4 row align-items-center">
                                        <label class="col-sm-3 col-form-label form-label-title">Category
                                            Image</label>
                                        <div class="form-group col-sm-9">
                                            <div class="dropzone-wrapper">
                                                <div class="dropzone-desc">
                                                    <i class="ri-upload-2-line"></i>
                                                    <p>Choose an image file or drag it here.</p>
                                                </div>
                                                <input type="file" class="dropzone dz-clickable">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-3 form-label-title">Select Category Icon</div>
                                        <div class="col-sm-9">
                                            <div class="dropdown icon-dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Select Icon
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/vegetable.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/cup.svg" class="blur-up lazyload" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/meats.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/breakfast.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/frozen.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/biscuit.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/grocery.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/drink.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/milk.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <img src="../assets/svg/1/pet.svg" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add New Category</button>
                                        </div>
                                    </div>
                                </form>
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
