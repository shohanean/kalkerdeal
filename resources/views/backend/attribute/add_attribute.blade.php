@extends('layouts.dashboardmaster')

@section('content')
<div class="page-body">
    <!-- New Product Add Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Add Size</h5>
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
                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('insert.size') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Size Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Size Name" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add Size</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Size Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sizes as $size)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $size->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Add Color Information</h5>
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
                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('insert.color') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Color Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Color Name" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Color Code <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input type="color" name="code">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add Color</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Color Name</th>
                                            <th scope="col">Color Palate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($colors as $color)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $color->name }}</td>
                                                <td>
                                                    <span class="badge" style="background:{{ $color->code }}">
                                                        &nbsp;
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
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
