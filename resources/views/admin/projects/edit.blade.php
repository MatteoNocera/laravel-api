@extends('layouts.admin')

@section('content')
    <div class="container py-4">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.projects.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Projects List
        </a>

        <div class="row row-cols-1 justify-content-around">
            <div class="col">
                <h2 class="my-5 display-3 fw-bold text-muted">Edit Project Id: #{{ $project->id }}</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('admin.projects.update', $project) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" placeholder=""
                                value="{{ old('title', $project->title) }}"
                                aria-describedby="project_id:{{ $project->id }}">
                            <small id="project_id:{{ $project->id }}"></small>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type_id" class="form-label">Types</label>
                            <select class="form-select @error('type_id') is-invalid @enderror" name="type_id"
                                id="type_id">
                                <option selected disabled>Select a type</option>
                                <option value="">None</option>

                                @forelse ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                                        {{ $type->name }}</option>
                                @empty
                                @endforelse

                            </select>
                            @error('type_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" rows="7" name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="web_link" class="form-label">Web Link</label>
                            <input type="text" class="form-control" @error('web_link') is-invalid @enderror
                                name="web_link" id="web_link" aria-describedby="help_web_link" placeholder=""
                                value="{{ old('web_link', $project->web_link) }}">

                            @error('web_link')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="git_link" class="form-label">GitHub Link</label>
                            <input type="text" class="form-control" @error('git_link') is-invalid @enderror
                                name="git_link" id="git_link" aria-describedby="help_git_link" placeholder=""
                                value="{{ old('git_link', $project->git_link) }}">

                            @error('git_link')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <span class="py-2">Technology</span>
                        <div class="list-group mb-4 overflow-y-auto" style="max-height: 200px">
                            @foreach ($technologies as $technology)
                                @if ($errors->any())
                                    <label class="list-group-item">
                                        <input class="form-check-input me-1 @error('technologies') is-invalid @enderror"
                                            name="technologies[]" type="checkbox" id="technologies{{ $technology->id }}"
                                            value="{{ $technology->id }}"
                                            {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                                        {{ $technology->name }}
                                    </label>
                                @else
                                    <label class="list-group-item">
                                        <input class="form-check-input me-1 @error('technologies') is-invalid @enderror"
                                            name="technologies[]" type="checkbox" id="technologies{{ $technology->id }}"
                                            value="{{ $technology->id }}"
                                            {{ $project->technologies->contains($technology) ? 'checked' : '' }}>
                                        {{ $technology->name }}
                                    </label>
                                @endif
                            @endforeach

                        </div>
                        @error('technologies')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="mb-4">
                            <label for="cover_image" class="form-label">Update Project Image</label>
                            <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder=""
                                aria-describedby="fileHelpId">

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a class="btn btn-secondary" href="{{ route('admin.projects.index') }}">
                            Cancel
                        </a>

                    </form>

            </div>
        </div>
    </div>
@endsection
