<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PDF;
use League\Csv\Writer;

class TasksController extends Controller
{
    /**
     * Ensure the user is authenticated for all methods.
     */
 

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = auth()->user()->tasks();

        // Apply filters
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        // Apply sorting
        if ($request->sort) {
            $query->orderBy($request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tasks = $query->get();

        // Prepare calendar events
        $calendarEvents = $tasks->map(function($task) {
            return [
                'title' => $task->task,
                'start' => $task->due_date?->format('Y-m-d'),
                'backgroundColor' => $task->status ? '#28a745' : 
                    ($task->priority === 'high' ? '#dc3545' : 
                    ($task->priority === 'medium' ? '#ffc107' : '#17a2b8')),
                'url' => route('tasks.show', $task->id)
            ];
        });

        return view('home', compact('tasks', 'calendarEvents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:not_started,in_progress,completed',
            'tags' => 'nullable|string'
        ]);

        $task = auth()->user()->tasks()->create([
            'task' => $validated['task'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'status' => $validated['status'] === 'completed',
            'labels' => $validated['tags'] ? explode(',', $validated['tags']) : null
        ]);

        if ($request->hasFile('attachment')) {
            // Handle file attachment here
        }

        return redirect()->route('tasks.index')->with("success", "Task created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        
        $var = auth()->user()->tasks()->findOrFail($id);
        return view('show', compact('var'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $updated = auth()->user()->tasks()->findOrFail($id);
        return view('edit', compact("updated"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255'
        ]);

        $task = auth()->user()->tasks()->findOrFail($id);
        $task->update($validated);

        return redirect()->route("tasks.index")->with("success", "Task updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();

        return redirect()->route("tasks.index")->with("success", "Task deleted successfully");
    }

    /**
     * Toggle the status of the specified task.
     */
    public function toggle(string $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->update(['status' => !$task->status]);

        return redirect()->route('tasks.index');
    }

    public function export($format)
    {
        $tasks = auth()->user()->tasks;

        if ($format === 'csv') {
            $csv = Writer::createFromString('');
            $csv->insertOne(['Task', 'Description', 'Due Date', 'Status', 'Priority']);
            
            foreach ($tasks as $task) {
                $csv->insertOne([
                    $task->task,
                    $task->description,
                    $task->due_date,
                    $task->status ? 'Completed' : 'Pending',
                    $task->priority
                ]);
            }

            return response($csv->toString())
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="tasks.csv"');
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('exports.tasks-pdf', compact('tasks'));
            return $pdf->download('tasks.pdf');
        }
    }

    public function share(Request $request, $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $user = User::where('email', $request->email)->firstOrFail();
        
        // Create a copy of the task for the other user
        $newTask = $task->replicate();
        $newTask->user_id = $user->id;
        $newTask->save();

        return back()->with('success', 'Task shared successfully');
    }

    public function addCollaborator(Request $request, string $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $collaborator = User::where('email', $request->email)->firstOrFail();
        
        $task->collaborators()->attach($collaborator->id);
        
        return back()->with('success', 'Collaborator added successfully');
    }

    public function removeCollaborator(string $taskId, string $userId)
    {
        $task = auth()->user()->tasks()->findOrFail($taskId);
        $task->collaborators()->detach($userId);
        
        return back()->with('success', 'Collaborator removed successfully');
    }
}
