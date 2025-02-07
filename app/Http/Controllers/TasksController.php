<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::all();
     return view('home',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task'=>'required|string|max:255',
             'status'=>'false'
        ]) ;
        tasks::create($validated);
       return redirect()->route('tasks.index')->with("success","task created succssefuly"); ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $var = Tasks::find($id);
        return view('show',compact('var')); ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $updated = Tasks::find($id);
        return view('edit',compact("updated"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'task'=>'required|string|max:255'

        ]);
       $task=Tasks::find($id);
        $task->update($validated);
        return redirect()->route("tasks.index")->with("success","task updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $task)
    {
        $task->delete();
       return redirect()->route("tasks.index")->with("success","task deleted");
    }

      /**
     * Toggle the status of the specified task.
     */
    public function toggle($id){
        $task = Tasks::find($id);
        $task->update(['status' => !$task->status]);
     
        return redirect()->route('tasks.index');
        }
  
    }

