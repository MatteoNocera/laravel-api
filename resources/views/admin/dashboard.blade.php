@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">

                        <h4>Welcome {{ Auth::user()->name }}, you are logged!</h4>


                    </div>


                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-3 my-5">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-body bg-dark text-white rounded-top">
                        <h4>
                            Total Projects: {{ $total_projects }}
                        </h4>
                    </div>
                    <div class="card-footer bg-secondary">
                        <a class="btn btn-outline-dark m-1" href="{{ route('admin.projects.index') }}">
                            See All
                            <i class="fa-regular fa-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-body bg-dark text-white rounded-top">
                        <h4>
                            Total Users: {{ $total_users }}
                        </h4>
                    </div>
                    <div class="card-footer bg-secondary">
                        <a class="btn btn-outline-dark m-1" href="#">
                            See All
                            <i class="fa-regular fa-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-body bg-dark text-white rounded-top">
                        <h4>
                            Total Types: {{ $total_types }}
                        </h4>
                    </div>
                    <div class="card-footer bg-secondary">
                        <a class="btn btn-outline-dark m-1" href="{{ route('admin.types.index') }}">
                            See All
                            <i class="fa-regular fa-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <h5 class="fs-4 text-secondary mt-4">Your Last Projects</h5>

        <div class="row row-cols-1 row-cols-lg-3 mt-1 g-4 my-4">
            @foreach ($projects as $project)
                <div class="col">
                    <div class="card text-center bg-dark text-white h-100 shadow border-0">
                        <div class="card-header bg-secondary text-black">
                            Project #{{ $project->id }}
                        </div>

                        <div class="card-img-top mt-2">

                            @if (str_contains($project->cover_image, 'http'))
                                <img width="100" src="{{ asset($project->cover_image) }}" alt="">
                            @else
                                <img width="100" src="{{ asset('storage/' . $project->cover_image) }}" alt="">
                            @endif


                        </div>
                        <div class="card-body">
                            <div class="card-title fw-bold">
                                {{ $project->title }}
                            </div>
                            <div class="card-text">
                                {{ $project->description }}
                            </div>

                        </div>
                        <div class="card-footer bg-secondary">
                            <a class="btn btn-outline-dark m-1" href="{{ $project->web_link }}" target="_blank"
                                rel="noopener noreferrer">
                                <i class="fa-solid fa-link fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
