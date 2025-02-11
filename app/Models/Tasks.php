<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    
    protected $fillable = ['task', 'status','user_id'];
    
    protected $casts=[
        'status'=>'boolean'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
