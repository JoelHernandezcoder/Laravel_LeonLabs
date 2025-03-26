<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('medication_production_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medication_id');
            $table->unsignedBigInteger('production_order_id');
            $table->unsignedBigInteger('sale_id');
            $table->integer('quantity');
            $table->decimal('sub_total', 20);
            $table->timestamps();

            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');
            $table->foreign('production_order_id')->references('id')->on('production_orders')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medication_production_order');
    }
};
