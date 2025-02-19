@extends('components.template')

@section('content')
<div class="card shadow-lg slide-up">
    <div class="card-header bg-gradient">
        <h3 class="card-title mb-0">Create New Task</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Task Name</label>
                <input type="text" name="task" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Due Date</label>
                    <input type="datetime-local" name="due_date" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Tags (comma separated)</label>
                <input type="text" name="tags" class="form-control" placeholder="work, personal, urgent">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-gradient">Create Task</button>
            </div>
        </form>
    </div>
</div>
@endsection
