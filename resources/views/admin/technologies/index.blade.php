@extends('layouts.admin')

@section('content')
    <div class="container">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.dashboard') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="d-flex justify-content-between">
            <h2 class="my-5 display-3 fw-bold text-muted">My Technologies</h1>

        </div>

        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Message: </strong> {{ session('message') }}
            </div>
        @endif

        <div class="card mt-4 shadow my-4">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover mb-0">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Id</th>

                            <th scope="col">Title</th>

                            <th scope="col">Project technologies count</th>

                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        @forelse ($technologies as $technology)
                            <tr class="table-secondary text-center">

                                <td class="align-middle" scope="row">{{ $technology->id }}</td>


                                <td class="col-4 text-center align-middle">{{ $technology->name }}</td>

                                <td class="col-4 text-center align-middle">{{ $technology->projects->count() }}</td>


                                <td class="text-center align-middle">

                                    <a href="{{ route('admin.technologies.edit', $technology) }}"
                                        class="btn btn-outline-dark"><i class="fa-solid fa-file-pen"></i></a>

                                    <!-- Modal trigger button -->
                                    <a type="button" class="btn btn-outline-danger mx-4" data-bs-toggle="modal"
                                        data-bs-target="#modalId{{ $technology->id }}"><i
                                            class="fa-solid fa-trash-can"></i></a>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId{{ $technology->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title" id="modalTitleId">Delete Type</h5>

                                                    <button type="button" class="btn-close bg-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-5">
                                                    <h4>Do you really want to delete this Technology?</h4>
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form
                                                        action="{{ route('admin.technologies.destroy', $technology->slug) }}"
                                                        method="POST">

                                                        @csrf

                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger">Confirm</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @empty
                            <tr class="table-secondary">

                                <td scope="row">No technologies yet!!!</td>

                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>

        </div>

        {{ $technologies->links('pagination::bootstrap-5') }}


        <div class="card shadow my-4">
            <div class="card-header">
                <h2>
                    Add a new Technology
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.technologies.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" @error('name') is-invalid @enderror name="name"
                            id="name" aria-describedby="help_name" placeholder="Type new technology name here"
                            value="">
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
