@extends('components.template')

@section('content')



<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="btn btn-primary">Tasks </h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">Create Task</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Task</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->task }}</td>
            <td>
                <form action="{{ route('tasks.toggle', $task->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $task->status ? 'btn-success' : 'btn-warning' }}">
                        {{ $task->status ? 'Completed' : 'Pending' }}
                    </button>
                </form>
            </td>
            <td>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">Show</a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="post" class="d-inline">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- <a href="{{route('dashboard')}}">logout</a> --}}

@endsection
