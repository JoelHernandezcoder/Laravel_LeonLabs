<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->decimal('total', 10, 2)->default(0);
            $table->date('agreed_date');
            $table->boolean('is_delivered')->default(false);
            $table->timestamps();
        });

        Schema::create('medication_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('medication_id')->constrained('medications');
            $table->integer('quantity');
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('medication_sale');
        Schema::dropIfExists('sales');
    }
}
