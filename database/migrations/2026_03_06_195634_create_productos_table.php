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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Crea el ID automático (Id_Producto)
            $table->string('nombre'); // Nombre del artículo
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->decimal('precio', 10, 2); // Precio con decimales
            $table->integer('stock')->default(0); // Cantidad disponible
            $table->boolean('activo')->default(true); // Para dar de baja sin borrar
            $table->timestamps(); // Crea 'created_at' y 'updated_at' automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
