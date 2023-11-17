@extends('layouts.admin')

@section('content')
    <div class="container py-4">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.technologies.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Technologies List
        </a>

        <div class="row row-cols-1 justify-content-around">
            <div class="col">
                <h2 class="my-5 display-3 fw-bold text-muted">Edit Technology Id: #{{ $technology->id }}</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('admin.technologies.update', $technology) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder=""
                                value="{{ old('name', $technology->name) }}"
                                aria-describedby="project_id:{{ $technology->id }}">
                            <small id="project_id:{{ $technology->id }}"></small>
                        </div>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror


                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a class="btn btn-secondary" href="{{ route('admin.technologies.index') }}">
                            Cancel
                        </a>

                    </form>

            </div>
        </div>
    </div>
@endsection
