@extends('components.template')

@section('content')

<div class="card shadow-lg p-4">
    <h2 class="text-primary mb-4"><i class="fas fa-plus-circle"></i> Create New Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="task" class="form-label">Task Name:</label>
            <input type="text" name="task" id="task" class="form-control" placeholder="Enter task..." required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter description..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="date" name="due_date" id="due_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="not_started">Not Started</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="attachment" class="form-label">Attachment:</label>
            <input type="file" name="attachment" id="attachment" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags:</label>
            <input type="text" name="tags" id="tags" class="form-control" 
                   placeholder="Enter tags separated by commas">
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary me-md-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Task
            </button>
        </div>
    </form>
</div>

@endsection
