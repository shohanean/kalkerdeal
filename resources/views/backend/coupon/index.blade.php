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
                            @if ($errors->any())
                                <div class="alert alert-info">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            @endif
                            <form class="theme-form theme-form-2 mega-form" method="POST" action="{{ route('coupon.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0"> Name <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" placeholder="Coupon Name" name="coupon_name">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Coupon Validity <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="date" placeholder="Coupon Validity" name="coupon_validity">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Coupon Discount (%) <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" placeholder="Coupon Discount" name="coupon_discount">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Coupon Limit <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" placeholder="Coupon Limit" name="coupon_limit">
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-success">Add New Coupon</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>All Coupons By {{ auth()->user()->name }}</h5>
                            </div>

                            <div class="table-responsive product-table">
                                <table class="table all-package theme-table" id="category_table">
                                    <thead>
                                        <tr>
                                            <th>SL. No</th>
                                            <th>coupon_name</th>
                                            <th>coupon_validity</th>
                                            <th>coupon_discount</th>
                                            <th>coupon_limit</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($coupons as $coupon)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $coupon->coupon_name }}</td>
                                                <td>
                                                    {{ $coupon->coupon_validity }}
                                                    <br>
                                                    <span class="badge bg-info">{{ \Carbon\Carbon::parse($coupon->coupon_validity)->diffInDays(now())+1 }} days left</span>
                                                </td>
                                                <td>{{ $coupon->coupon_discount }}%</td>
                                                <td>{{ $coupon->coupon_limit }}</td>

                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="3">No Coupon Added Yet</td>
                                            </tr>
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

@section('footer_scripts')
<script>
    $(document).ready(function(){
        $('#product_table').DataTable();
        $('#product_table').on('click', '.product_delete_btn', function(){
            var link = $(this).val();
            // sweetaleart code start
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            })
            // sweetaleart code end
        });
    });
</script>
@endsection
