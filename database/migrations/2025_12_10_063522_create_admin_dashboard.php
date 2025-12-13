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
        Schema::create('admin_dashboard', function (Blueprint $table) {
            $table->id();

            // Unique identifier for each dashboard section
            $table->string('section_key')->unique();

            // Display title for the dashboard block
            $table->string('title');

            // Short description of the section
            $table->string('description')->nullable();

            // FontAwesome icon class
            $table->string('icon')->nullable();

            // Route to navigate when this block is clicked
            $table->string('route_name')->nullable();

            // Enable/Disable dashboard block
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_dashboard');
    }
};
