<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->text('description');
            $table->bigInteger('cluster_id')->unsigned();
            $table->foreign('cluster_id')
                ->references('id')
                ->on('clusters')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->dateTime('start')->nullable();
            $table->integer('progress')->default(0)->nullable();
            $table->enum('status', ['Shared', 'Started', 'Analysis', 'Development', 'Done'])->default('Shared');
            $table->dateTime('finish')->nullable();
            $table->string('evidence_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
