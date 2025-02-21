<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = auth()->user()->tasks()
            ->where('is_template', true)
            ->get();
        
        return view('templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $task = auth()->user()->tasks()->findOrFail($request->task_id);
        
        // Create template from task
        $template = $task->replicate();
        $template->is_template = true;
        $template->status = false;
        $template->due_date = null;
        $template->save();

        return back()->with('success', 'Template created successfully');
    }

    public function createFromTemplate(string $id)
    {
        $template = Tasks::findOrFail($id);
        
        $task = $template->replicate();
        $task->is_template = false;
        $task->save();

        return redirect()->route('tasks.edit', $task->id)
            ->with('success', 'Task created from template');
    }

    public function destroy(string $id)
    {
        $template = auth()->user()->tasks()
            ->where('is_template', true)
            ->findOrFail($id);
            
        $template->delete();
        
        return back()->with('success', 'Template deleted successfully');
    }
}
