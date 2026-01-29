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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')
                ->nullable();
            $table->string('last_name')
                ->nullable();
            $table->string('email')
                ->unique();
            $table->string('username')
                ->unique();
            $table->string('password');
            $table->string('phone_number')
                ->nullable();
            $table->text('address')
                ->nullable();
            $table->string('profile_picture')
                ->nullable();
            $table->foreignId('gender_id');
            $table->date('last_reset_password')
                ->nullable();
            $table->dateTime('last_login')
                ->nullable();
            $table->dateTime('phone_number_verificated_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
