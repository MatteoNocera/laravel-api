@extends('layouts.admin')

@section('content')
    <div class="container">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.types.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Types List
        </a>

        <h2 class="my-5 display-3 fw-bold text-muted">Create New Type</h1>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('admin.types.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" @error('name') is-invalid @enderror name="name"
                                id="name" aria-describedby="help_name" placeholder="Type new type name here"
                                value="{{ old('name', $type->name) }}">
                            <small id="help_name" class="form-text text-muted">Type max 50 characters</small>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <button class="btn btn-primary" type="submit">Save</button>

                    </form>
                </div>
            </div>
    </div>
@endsection
