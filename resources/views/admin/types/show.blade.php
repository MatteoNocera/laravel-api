@extends('layouts.admin')

@section('content')
    <div class="container">

        <a class="btn btn-secondary mt-2" href="{{ route('admin.types.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Projects List
        </a>

        <h2 class="my-5 display-3 fw-bold text-muted">Type n° : #{{ $type->id }}
        </h2>

        <div class="row py-4">

            <div class="col">
                <div class="card mb-3 shadow-lg bg-dark text-white">

                    <div class="row g-0">

                        <div class="col">
                            <div class="card-body">
                                <h5 class="card-title fs-4 my-4"><span class="text-white-50">Name:
                                    </span>{{ $type->name }}
                                </h5>


                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end bg-secondary bg-gradient align-items-center gap-4">


                        <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-outline-dark"><i
                                class="fa-solid fa-file-pen"></i></a>

                        <!-- Modal trigger button -->
                        {{-- <button type="button" class="btn btn-danger ms-4" data-bs-toggle="modal" data-bs-target="#modalId">
                            Delete
                        </button> --}}
                        <a type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalId">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <!-- Modal Body -->
                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title" id="modalTitleId">Delete Type</h5>

                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-5">
                                        <h4 class="text-black">Do you really want to delete this Type?</h4>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>

                                        <form action="{{ route('admin.types.destroy', $type->slug) }}" method="POST">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">Confirm</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>




    </div>
@endsection
