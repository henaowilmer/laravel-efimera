<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con el usuario
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con el producto
            $table->integer('quantity'); // Cantidad de productos
            $table->decimal('total_price', 8, 2); // Precio total
            $table->decimal('taxes', 8, 2)->default(0); // Impuestos
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}

