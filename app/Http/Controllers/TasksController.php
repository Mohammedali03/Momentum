<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TasksController extends Controller
{
    /**
     * Ensure the user is authenticated for all methods.
     */
 

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Retrieve only tasks for the authenticated user
        $tasks = auth()->user()->tasks()->get();
        return view('home', compact('tasks'));
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
        ]);

        // Create task for the authenticated user
        auth()->user()->tasks()->create([
            'task' => $validated['task'],
            'status' => false, // Default status
        ]);

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
}
