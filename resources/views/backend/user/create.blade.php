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
                                    <h5>User Information</h5>
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
                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ url('user/insert') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Email <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Profile Photo</label>
                                        <div class="col-sm-9">
                                            <style>
                                                .hidden{
                                                    visibility: hidden;
                                                }
                                            </style>
                                            <input class="form-control" type="file" name="profile_photo" onchange="showImage(this);">
                                            <img class="mt-3 hidden" id="profile_photo_viewer" src="#" alt="your image"/>
                                            <script>
                                                function showImage(input) {
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();
                                                        reader.onload = function (e) {
                                                        $('#profile_photo_viewer').attr('src', e.target.result).width(195).height(150);
                                                        };
                                                        $('#profile_photo_viewer').removeClass('hidden');
                                                        reader.readAsDataURL(input.files[0]);
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Role <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="role">
                                                <option value="">-Select One Role-</option>
                                                <option value="vendor">Vendor</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add New User</button>
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
