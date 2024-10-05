<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('name'); // Nombre del producto
            $table->boolean('active')->default(true); // Estado activo/inactivo
            $table->decimal('price', 8, 2); // Precio, máximo 8 dígitos y 2 decimales
            $table->integer('stock'); // Stock disponible
            $table->string('ean13', 13)->unique(); // Código EAN-13, único
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
