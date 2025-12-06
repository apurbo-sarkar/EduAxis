<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('full_name');
            $table->string('admission_number')->unique(); 
            $table->date('date_of_birth');
            $table->string('gender', 50);
            $table->string('student_class'); 
            $table->string('blood_group', 5)->nullable();
            $table->string('student_email')->nullable(); 
            $table->string('password'); 
            $table->rememberToken(); 
            $table->string('parent1_name');
            $table->string('parent1_phone', 20); 
            $table->string('parent1_email');
            $table->string('parent2_name')->nullable();
            $table->string('parent2_phone', 20)->nullable();
            $table->text('address');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone', 20);
            $table->text('medical_notes')->nullable();
            $table->boolean('terms_agreed')->default(false);
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
