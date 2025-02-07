<?php

use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TasksController::class);

Route::patch('/tasks/toggle/{id}', [TasksController::class, 'toggle'])->name('tasks.toggle');

