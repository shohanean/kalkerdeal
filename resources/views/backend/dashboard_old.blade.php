<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | {{ env('APP_DESCRIPTION') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Reserved</a>
                </li>
            </ul>
                <ul style="list-style: none">
                    <li class="d-flexnav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">Logout</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">
                        List Category (Active)
                        <span class="badge bg-info">{{ count($categories) }}</span>
                    </h4>
                  </div>
                  <div class="card-body">
                    @if (session('delete_success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Done!</strong> {{ session('delete_success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL. No</th>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Created At</th>
                                    <th>Last Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>{{ $category->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($category->updated_at)
                                                {{ $category->updated_at->diffForHumans() }}
                                            @else
                                                <div class="badge bg-danger">
                                                    Not Updated Yet
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('category/delete') }}/{{ $category->id }}" class="btn btn-sm btn-warning">Delete</a>
                                                <a href="{{ url('category/update') }}/{{ $category->id }}" class="btn btn-sm btn-info">Update</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center text-danger">
                                        <td colspan="50">No Category to show</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                  </div>
                </div>
                <div class="card mt-5">
                  <div class="card-header bg-danger">
                    <h4 class="card-title">
                        List Category (Recycle Bin)
                        <span class="badge bg-info">{{ count($trashed_categories) }}</span>
                    </h4>
                  </div>
                  <div class="card-body">
                    @if (session('restore_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Done!</strong> {{ session('restore_success') }}
                        </div>
                    @endif
                    <div class="btn-group my-3" role="group" aria-label="Basic mixed styles example">
                        <a href="{{ url('category/all/restore') }}" class="btn btn-success">Restore All</a>
                        <a href="{{ url('category/all/permanant/delete') }}" class="btn btn-danger">Permanant Delete All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL. No</th>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashed_categories as $trashed_category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $trashed_category->name }}</td>
                                        <td>{{ $trashed_category->description }}</td>
                                        <td>{{ $trashed_category->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('category/restore') }}/{{ $trashed_category->id }}" class="btn btn-sm btn-success">Restore</a>
                                                <a href="{{ url('category/permanent/delete') }}/{{ $trashed_category->id }}" class="btn btn-sm btn-danger">P. Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                  </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                    <p class="card-text">With this below form you add new category</p>
                  </div>
                  <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ url('category/insert') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info">Add Category</button>
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
