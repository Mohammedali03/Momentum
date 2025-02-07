@extends('components.template')

@section('content')

<div class="card shadow-lg p-4">
    <h1 class="text-primary">{{ $var->task }}</h1>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Task Name:</strong> {{ $var->task }}</li>
        <li class="list-group-item">
            <strong>Status:</strong> 
            <span class="badge {{ $var->status ? 'bg-success' : 'bg-warning' }}">
                {{ $var->status ? 'Completed' : 'Pending' }}
            </span>
        </li>
        <li class="list-group-item"><strong>Created At:</strong> {{ $var->created_at->format('d M Y - H:i') }}</li>
        <li class="list-group-item"><strong>Updated At:</strong> {{ $var->updated_at->format('d M Y - H:i') }}</li>
    </ul>

    <div class="mt-4">
        <a href="{{ route('tasks.edit', $var->id) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>

@endsection
