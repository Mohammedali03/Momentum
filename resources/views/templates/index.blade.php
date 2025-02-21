@extends('components.template')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Task Templates</h3>
        <a href="{{ route('tasks.index') }}" class="btn btn-light">Back to Tasks</a>
    </div>
    <div class="card-body">
        @if($templates->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-clipboard fa-3x text-muted mb-3"></i>
                <h4>No templates yet</h4>
                <p>Save any task as a template to reuse it later.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($templates as $template)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $template->task }}</h5>
                                <p class="card-text">{{ Str::limit($template->description, 100) }}</p>
                                <div class="mt-3">
                                    <span class="badge bg-{{ $template->priority == 'high' ? 'danger' : ($template->priority == 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($template->priority) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <form action="{{ route('templates.create-from', $template->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Create Task
                                    </button>
                                </form>
                                <form action="{{ route('templates.destroy', $template->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
