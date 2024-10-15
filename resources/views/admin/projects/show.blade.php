@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-center pb-3">{{ $project->name }}</h1>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-decoration-none btn btn-sm btn-warning fw-semibold">Edit</a>
                        <a href="{{ route('admin.projects.index') }}" class="text-decoration-none btn btn-sm btn-secondary fw-semibold">
                            <i class="bi bi-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="border border-2 rounded-2">
                                @if (Str::startsWith($project->image_path, 'https'))
                                    <img src="{{ $project->image_path }}" class="img-fluid border border-2 rounded-2" alt="Project {{ $project->name }}">
                                @else
                                    <img src="{{ asset('storage/'. $project->image_path) }}" class="img-fluid border border-2 rounded-2" alt="Project {{ $project->name }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Project Details</h5>
                                <p class="card-text"><strong>Description:</strong> {{ $project->description }}</p>
                                <p class="card-text"><strong>Start Date:</strong> {{ date('M d, Y', strtotime($project->start_date)) }}</p>
                                <p class="card-text"><strong>End Date:</strong> {{ $project->end_date ? date('M d, Y', strtotime($project->end_date)) : 'Ongoing' }}</p>
                                <p class="card-text"><strong>Stack:</strong> {{ $project->stack }}</p>
                                <p class="card-text"><strong>Status:</strong> 
                                    @if($project->status)
                                        <span class="badge bg-success">Compleated</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </p>
                                <p class="card-text"><strong>Type:</strong>{{ $project->type ? $project->type->name : ' No type assigned' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection