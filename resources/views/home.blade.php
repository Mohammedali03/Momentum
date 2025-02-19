@extends('components.template')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Tasks</h5>
                <h2>{{ $tasks->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Completed</h5>
                <h2>{{ $tasks->where('status', true)->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Pending</h5>
                <h2>{{ $tasks->where('status', false)->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">High Priority</h5>
                <h2>{{ $tasks->where('priority', 'high')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Progress Bar -->
<div class="card mb-4">
    <div class="card-body">
        @php
            $progress = $tasks->count() > 0 
                ? ($tasks->where('status', true)->count() / $tasks->count()) * 100 
                : 0;
        @endphp
        <h5>Overall Progress</h5>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: {{ $progress }}%" 
                 aria-valuenow="{{ $progress }}" 
                 aria-valuemin="0" 
                 aria-valuemax="100">{{ round($progress) }}%</div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="btn btn-primary">Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">Create Task</a>
</div>

<!-- Add Filter and Sort Options -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="priority" class="form-select">
                    <option value="">Filter by Priority</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="due_date">Sort by Due Date</option>
                    <option value="priority">Sort by Priority</option>
                    <option value="status">Sort by Status</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Views Toggle -->
<div class="card mb-4">
    <div class="card-header">
        <ul class="nav nav-tabs" id="taskViews" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button" role="tab">
                    List View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view" type="button" role="tab">
                    Calendar View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">
                    Analytics
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="taskViewsContent">
            <div class="tab-pane fade show active" id="list-view" role="tabpanel">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Task</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->task }}</td>
                            <td>{{ Str::limit($task->description, 50) }}</td>
                            <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No date' }}</td>
                            <td><span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'info') }}">
                                {{ ucfirst($task->priority) }}
                            </span></td>
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
            </div>
            <div class="tab-pane fade" id="calendar-view" role="tabpanel">
                <div id="calendar"></div>
            </div>
            <div class="tab-pane fade" id="analytics" role="tabpanel">
                <div class="chart-container" style="position: relative; height:60vh; width:80vw">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Options -->
<div class="dropdown mb-3">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
        Export Tasks
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('tasks.export', 'csv') }}">Export as CSV</a></li>
        <li><a class="dropdown-item" href="{{ route('tasks.export', 'pdf') }}">Export as PDF</a></li>
    </ul>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs
    const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            if (event.target.getAttribute('data-bs-target') === '#calendar-view') {
                calendar.render();
            }
            if (event.target.getAttribute('data-bs-target') === '#analytics') {
                if (window.taskChart) {
                    window.taskChart.resize();
                }
            }
        });
    });

    // Initialize Calendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($calendarEvents),
        eventClick: function(info) {
            if (info.event.url) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            }
        },
        height: 'auto',
        aspectRatio: 1.8
    });

    // Update chart initialization
    const ctx = document.getElementById('taskChart');
    if (ctx) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        const colors = ThemeToggle.getChartColors(isDark);
        
        window.taskChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Completed', 'Pending', 'High Priority'],
                datasets: [{
                    label: 'Task Statistics',
                    data: [
                        {{ $tasks->where('status', true)->count() }},
                        {{ $tasks->where('status', false)->count() }},
                        {{ $tasks->where('priority', 'high')->count() }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        labels: { color: colors.text }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: colors.text
                        },
                        grid: {
                            color: colors.grid,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: colors.text
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Initial render of calendar
    calendar.render();
});
</script>
@endpush
