@extends('layouts.dashboardmaster')

@section('content')
    <!-- Container-fluid starts-->
    <div class="page-body">
        <!-- All User Table Start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>All Users</h5>
                                <form class="d-inline-flex">
                                    <a href="{{ url('user/create') }}" class="align-items-center btn btn-theme">
                                        <i class="fa fa-plus-square"></i>
                                        Add New User
                                    </a>
                                </form>
                            </div>

                            <div class="table-responsive category-table">
                                <table class="table all-package theme-table" id="table_id">
                                    <thead>
                                        <tr>
                                            <th>Profile Photo</th>
                                            <th>SL. No</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>Account Creation Date</th>
                                            <th>Role</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td>
                                                    @if ($user->profile_photo)
                                                        <img width="50" src="{{ asset('uploads/profile_photos') }}/{{ $user->profile_photo }}" alt="">
                                                    @else
                                                        <img width="50" src="{{ Avatar::create($user->name)->setShape('square')->toBase64() }}" alt="not found"/>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>---</td>
                                            </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- All User Table Ends-->

        @include('parts.copyright')
    </div>
    <!-- Container-fluid end -->
@endsection
