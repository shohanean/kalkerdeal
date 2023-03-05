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
                                <h5>Updating Now: {{ $category->name }} </h5>
                            </div>
                            <form action="{{ url('category/edit') }}/{{ $category->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Category Description</label>
                                    <textarea name="description" class="form-control" rows="5">{{ $category->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Current Category Thumbnail</label>
                                    <br>
                                    <img src="{{ asset('uploads/category_thumbnails') }}/{{ $category->category_thumbnail }}" alt="not found" width="100">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Category Thumbnail</label>
                                    <input type="file" class="form-control" name="category_thumbnail">
                                </div>
                                <button type="submit" class="btn btn-secondary">Update Category</button>
                            </form>
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
