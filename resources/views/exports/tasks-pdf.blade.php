<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Tasks Report</h1>
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date?->format('Y-m-d') }}</td>
                    <td>{{ $task->status ? 'Completed' : 'Pending' }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
