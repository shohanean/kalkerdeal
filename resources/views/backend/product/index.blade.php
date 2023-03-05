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
                                <h5>All Products</h5>
                                <form class="d-inline-flex">
                                    <a href="{{ route('product.create') }}" class="align-items-center btn btn-theme">
                                        <i class="fa fa-plus-square"></i>
                                        Add New Product
                                    </a>
                                </form>
                            </div>

                            <div class="table-responsive product-table">
                                <table class="table all-package theme-table" id="category_table">
                                    <thead>
                                        <tr>
                                            <th>SL. No</th>
                                            <th>Category Name</th>
                                            <th>Product Thumbnail</th>
                                            <th>Product Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    {{ $product->relationshipwithcategory->name }}
                                                    <p>
                                                        <a href="">{{ $product->relationshipwithcategory->slug }}</a>
                                                    </p>
                                                    {{-- {{ App\Models\Category::find($product->category_id)->name }} --}}
                                                </td>
                                                <td>
                                                    <img width="100" src="{{ asset('uploads/product_thumbnails') }}/{{ $product->product_thumbnail }}" alt="not found">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    <a href="{{ route('add.inventory', $product->id) }}" class="btn btn-sm btn-danger">
                                                        Add Inventory
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="3">No Product Uploaded Yet</td>
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
