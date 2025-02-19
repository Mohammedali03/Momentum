<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the table first to avoid conflicts
        Schema::dropIfExists('task_collaborators');

        // Create a fresh task_collaborators table
        Schema::create('task_collaborators', function (Blueprint $table) {
            $table->id();
            
            // Foreign key for tasks
            $table->unsignedBigInteger('tasks_id');
            $table->foreign('tasks_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');
            
            // Foreign key for users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            $table->timestamps();

            // Add unique constraint to prevent duplicate collaborations
            $table->unique(['tasks_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_collaborators');
    }
};
