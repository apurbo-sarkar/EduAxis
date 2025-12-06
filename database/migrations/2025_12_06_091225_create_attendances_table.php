<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');

            $table->unsignedBigInteger('student_id');

            $table->year('current_year');
            $table->string('January', 50)->nullable();
            $table->string('February', 50)->nullable();
            $table->string('March', 50)->nullable();
            $table->string('April', 50)->nullable();
            $table->string('May', 50)->nullable();
            $table->string('June', 50)->nullable();
            $table->string('July', 50)->nullable();
            $table->string('August', 50)->nullable();
            $table->string('September', 50)->nullable();
            $table->string('October', 50)->nullable();
            $table->string('November', 50)->nullable();
            $table->string('December', 50)->nullable();

            $table->timestamps();

            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('students')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};


