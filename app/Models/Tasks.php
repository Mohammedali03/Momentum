<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'task',
        'description',
        'status',
        'user_id',
        'due_date',
        'priority',
        'category',
        'parent_id',
        'is_template',
        'reminder_at',
        'labels'
    ];
    
    protected $casts = [
        'status' => 'boolean',
        'due_date' => 'datetime',
        'reminder_at' => 'datetime',
        'is_template' => 'boolean',
        'labels' => 'array'
    ];

    const PRIORITIES = ['low', 'medium', 'high'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Tasks::class, 'parent_id');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_collaborators');
    }
}
