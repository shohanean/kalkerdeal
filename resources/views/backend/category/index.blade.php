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
                                <h5>All Category</h5>
                                <form class="d-inline-flex">
                                    <a href="{{ url('category/create') }}" class="align-items-center btn btn-theme">
                                        <i class="fa fa-plus-square"></i>
                                        Add New Category
                                    </a>
                                </form>
                            </div>

                            <div class="table-responsive category-table">
                                <table class="table all-package theme-table" id="category_table">
                                    <thead>
                                        <tr>
                                            <th>SL. No</th>
                                            <th>Category Name</th>
                                            <th>Add Date</th>
                                            <th>Updated Date</th>
                                            <th>Category Image</th>
                                            <th>Slug</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    {{ $category->name }}
                                                </td>
                                                <td>
                                                    {{ $category->created_at->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if ($category->updated_at)
                                                        {{ $category->updated_at->diffForHumans() }}
                                                    @else
                                                        <span class="badge bg-info">Not Updated Yet</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="table-image">
                                                        <img src="{{ asset('uploads/category_thumbnails') }}/{{ $category->category_thumbnail }}" class="img-fluid" alt="not found">
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $category->slug }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ url('category/update') }}/{{ $category->id }}">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <button value="{{ url('category/delete') }}/{{ $category->id }}" class="btn btn-sm btn-danger category_delete_btn">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
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

@section('footer_scripts')
<script>
    $(document).ready(function(){
        $('#category_table').DataTable();
        $('#category_table').on('click', '.category_delete_btn', function(){
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
