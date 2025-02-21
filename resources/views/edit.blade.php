@extends('components.template')

@section('content')
<div class="card shadow-lg slide-up">
    <div class="card-header bg-gradient">
        <h3 class="card-title mb-0">Edit Task</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.update', $updated->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="form-label">Task Name</label>
                <input type="text" name="task" class="form-control" value="{{ $updated->task }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $updated->description }}</textarea>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Due Date</label>
                    <input type="datetime-local" name="due_date" class="form-control" 
                           value="{{ $updated->due_date ? $updated->due_date->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="low" {{ $updated->priority == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $updated->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $updated->priority == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Tags</label>
                @include('components.tag-manager', ['tags' => $updated->labels ?? []])
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-gradient">Update Task</button>
            </div>
        </form>
    </div>
</div>
@endsection
