<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('mathematics', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('student_id');
            $table->integer('quiz')->default(0); 
            $table->integer('assignment')->default(0); 
            $table->integer('mid_exam')->default(0); 
            $table->integer('final_exam')->default(0);
            $table->integer('marks_obtained')->default(0);
            $table->string('grade_obtained', 2)->nullable(); 
            $table->timestamps(); 


            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('students')
                  ->onDelete('cascade');

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('mathematics');
    }
};

