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
            $table->string('name');
            $table->text('description');
            $table->bigInteger('cluster_id')->unsigned();
            $table->foreign('cluster_id')
                ->references('id')
                ->on('clusters')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->date('date');
            $table->date('deadline');
            $table->integer('progress')->default(0);
            $table->enum('status', ['Shared', 'Started', 'Analysis', 'Development', 'Done'])->default('Shared');
            $table->date('finish')->nullable();
            $table->date('evidence_file');
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
