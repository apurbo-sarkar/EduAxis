<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('fee_structure_id')->nullable();
            $table->string('item_name');
            $table->decimal('amount', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->timestamps();
            
            $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');
            $table->foreign('fee_structure_id')->references('fee_structure_id')->on('fee_structures')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};