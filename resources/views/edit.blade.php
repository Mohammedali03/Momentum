@extends('components.template')

@section('content')

<div class="card shadow-lg p-4">
    <h2 class="text-primary">Edit Task</h2>

    <form action="{{ route('tasks.update', $updated->id) }}" method="post" class="mt-3">
        @csrf
        @method("PUT")

        <div class="mb-3">
            <label for="task" class="form-label">Task Name:</label>
            <input type="text" name="task" id="task" class="form-control" value="{{ $updated->task }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Home</a>
    </form>
</div>

@endsection
