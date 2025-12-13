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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // Basic personal info
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);

            // Contact info
            $table->string('phone', 20);
            $table->string('email')->unique();

            // Address
            $table->string('present_address');
            $table->string('permanent_address');

            // Extra identification
            $table->string('national_id')->nullable()->unique();
            $table->string('photo')->nullable(); // file path

            $table->string('username')->unique();
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
