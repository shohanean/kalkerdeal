@extends('layouts.dashboardmaster')

@section('content')
<div class="page-body">
    <!-- New Product Add Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Change Password</h5>
                                </div>

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


                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('change.password') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Current Password <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="password" placeholder="Current Password" name="current_password">
                                            @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">New Password <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="password" placeholder="New Password" name="password">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Confirm Password <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation">
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Change Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Change Information</h5>
                                </div>

                                @if (session('information_success'))
                                    <div class="alert alert-success">
                                        {{ session('information_success') }}
                                    </div>
                                @endif

                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('change.information') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row my-4">
                                        <div class="col-sm-12 text-center">
                                        @if (auth()->user()->profile_photo)
                                            <img width="100" class="user-profile rounded-circle" src="{{ asset('uploads/profile_photos') }}/{{ auth()->user()->profile_photo }}" alt="">
                                        @else
                                            <img class="user-profile rounded-circle" src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" alt="not found"/>
                                        @endif
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Profile Photo</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="profile_photo">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Name" name="name" value="{{ auth()->user()->name }}">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-info">Change</button>
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
