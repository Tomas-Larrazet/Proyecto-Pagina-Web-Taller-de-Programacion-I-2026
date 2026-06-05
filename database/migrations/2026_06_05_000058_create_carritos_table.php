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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            
            // Relación con el usuario (quién es el dueño de este producto en el carrito)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relación con el producto (qué producto agregó)
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            // La cantidad de unidades que quiere llevar
            $table->integer('cantidad')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
