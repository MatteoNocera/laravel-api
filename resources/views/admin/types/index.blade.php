@extends('layouts.admin')

@section('content')
    <div class="container">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.dashboard') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="d-flex justify-content-between">
            <h2 class="my-5 display-3 fw-bold text-muted">My Types</h1>

                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-outline-primary " href="{{ route('admin.types.create') }}">➕ Add Type</a>
                    {{-- <a class="btn btn-outline-danger " href="{{ route('types.trashed') }}">🗑 See Trashed
                        Types</a> --}}
                </div>

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

                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        @forelse ($types as $type)
                            <tr class="table-secondary text-center">

                                <td class="align-middle" scope="row">{{ $type->id }}</td>


                                <td class="col-4 text-center align-middle">{{ $type->name }}</td>


                                <td class="text-center align-middle">

                                    <a href="{{ route('admin.types.show', $type->slug) }}"
                                        class="btn btn-outline-info mx-4"><i class="fa-solid fa-eye"></i></a>


                                    <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-file-pen"></i></a>

                                    <!-- Modal trigger button -->
                                    <a type="button" class="btn btn-outline-danger mx-4" data-bs-toggle="modal"
                                        data-bs-target="#modalId"><i class="fa-solid fa-trash-can"></i></a>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title" id="modalTitleId">Delete Type</h5>

                                                    <button type="button" class="btn-close bg-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-5">
                                                    <h4>Do you really want to delete this Type?</h4>
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form action="{{ route('admin.types.destroy', $type->slug) }}"
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

                                <td scope="row">No Types yet!!!</td>

                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>

        </div>

        {{ $types->links('pagination::bootstrap-5') }}

    </div>
@endsection
