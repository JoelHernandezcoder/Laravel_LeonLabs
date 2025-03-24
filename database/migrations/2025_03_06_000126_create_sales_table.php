<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up(): void
    {
        // Creamos la tabla de ventas
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->decimal('total', 10, 2)->default(0); // Total de la venta
            $table->date('agreed_date');
            $table->boolean('is_delivered')->default(false);
            $table->timestamps();
        });

        // Creamos la tabla intermedia para la relación muchos a muchos entre ventas y medicamentos
        Schema::create('medication_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('medication_id')->constrained('medications');
            $table->integer('units'); // Unidades de medicamento
            $table->decimal('sub_total', 10, 2); // Subtotal de ese medicamento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_sale');
        Schema::dropIfExists('sales');
    }
}
