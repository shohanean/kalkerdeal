@extends('layouts.frontendmaster')

@section('content')
<h1>
    Category ({{ $categories->count() }})
</h1>

<div class="table-responsive">
    <table border="1" class="table table-primary">
        <thead>
            <tr>
                <th scope="col">SL No.</th>
                <th scope="col">Category Name</th>
                <th scope="col">Category Description</th>
                <th scope="col">Created At</th>
                <th scope="col">Custom (DD/MM/YYYY)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ Str::title($category->name) }}</td>
                    <td>{{ Str::title($category->description) }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        {{ $category->created_at->format('d F, Y') }}
                        <br>
                        {{ $category->created_at->format('h:i:s A') }}
                        <br>
                        {{ $category->created_at->diffForHumans() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
