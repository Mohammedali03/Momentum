@extends('components.template')

@section('content')
<div class="card shadow-lg p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">{{ $var->task }}</h1>
        <span class="badge bg-{{ $var->priority == 'high' ? 'danger' : ($var->priority == 'medium' ? 'warning' : 'info') }}">
            {{ ucfirst($var->priority) }}
        </span>
    </div>

    <!-- Task Details -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>Description</h5>
                    <p>{{ $var->description }}</p>
                    
                    <h5>Due Date</h5>
                    <p>{{ $var->due_date?->format('Y-m-d H:i') }}</p>

                    @if($var->labels)
                        <h5>Labels</h5>
                        <div class="mb-3">
                            @foreach($var->labels as $label)
                                <span class="badge bg-primary me-1">{{ $label }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Collaborators Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Collaborators</h5>
                    <div class="mb-3">
                        @foreach($var->collaborators as $collaborator)
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2">{{ $collaborator->name }}</span>
                                <form action="{{ route('tasks.remove-collaborator', [$var->id, $collaborator->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Add Collaborator Form -->
                    <form action="{{ route('tasks.add-collaborator', $var->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Collaborator's email">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Subtasks Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Subtasks</h5>
            <ul class="list-group mb-3">
                @foreach($var->subtasks as $subtask)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <input type="checkbox" class="form-check-input me-2" 
                                   {{ $subtask->status ? 'checked' : '' }}
                                   onchange="document.getElementById('toggle-form-{{ $subtask->id }}').submit()">
                            {{ $subtask->task }}
                        </div>
                        <form id="toggle-form-{{ $subtask->id }}" 
                              action="{{ route('tasks.toggle', $subtask->id) }}" 
                              method="POST" class="d-none">
                            @csrf
                            @method('PATCH')
                        </form>
                    </li>
                @endforeach
            </ul>
            
            <!-- Add Subtask Form -->
            <form action="{{ route('tasks.add-subtask', $var->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="task" class="form-control" placeholder="New subtask">
                    <button type="submit" class="btn btn-primary">Add Subtask</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('tasks.edit', $var->id) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Home</a>
        
        <!-- Save as Template Button -->
        <form action="{{ route('tasks.save-template', $var->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-info">Save as Template</button>
        </form>
    </div>
</div>
@endsection
