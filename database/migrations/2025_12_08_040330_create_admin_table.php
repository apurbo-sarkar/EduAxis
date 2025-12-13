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
    {Schema::create('admins', function (Blueprint $table) {
    $table->id();
    $table->string('admin_id')->unique();
    $table->string('full_name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('role');
    $table->text('address')->nullable();
    $table->boolean('terms_agreed')->default(false);
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
