@extends('layouts.app')

@section('content')
    <div class="container my-5 text-center">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-center pb-3">Projects</h1>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a href="{{ route('admin.projects.create') }}" class="text-decoration-none btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-12">
                <table class="table table-striped mx-auto">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="fw-bold">{{ $project->id }}</td>
                                <td class="text-capitalize fst-italic">{{ $project->name }}</td>
                                <td>{{ date('M d Y', strtotime($project->date_of_upload)) }}</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="{{ route('admin.projects.show', $project->id) }}"
                                        class="text-decoration-none btn btn-sm btn-primary fw-semibold me-3">View</a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger button_delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.projects.partials.modal_delete')
@endsection