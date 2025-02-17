<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
   
    Route::resource('tasks', TasksController::class);

    Route::patch('/tasks/toggle/{id}', [TasksController::class, 'toggle'])->name('tasks.toggle');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Export route
    Route::get('/tasks/export/{format}', [TasksController::class, 'export'])
        ->name('tasks.export')
        ->where('format', 'csv|pdf');
    
    // Task collaboration routes
    Route::post('/tasks/{task}/collaborators', [TasksController::class, 'addCollaborator'])
        ->name('tasks.add-collaborator');
    Route::delete('/tasks/{task}/collaborators/{user}', [TasksController::class, 'removeCollaborator'])
        ->name('tasks.remove-collaborator');
    
    // Subtask routes
    Route::post('/tasks/{task}/subtasks', [TasksController::class, 'addSubtask'])
        ->name('tasks.add-subtask');
    
    // Template routes
    Route::post('/tasks/{task}/template', [TasksController::class, 'saveTemplate'])
        ->name('tasks.save-template');
    Route::get('/templates', [TasksController::class, 'templates'])
        ->name('tasks.templates');
});

require __DIR__.'/auth.php';
