<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'is_template')) {
                $table->boolean('is_template')->default(false);
            }
            // Add these columns if they don't exist as well
            if (!Schema::hasColumn('tasks', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('tasks', 'reminder_at')) {
                $table->dateTime('reminder_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['is_template', 'category', 'reminder_at']);
        });
    }
};
