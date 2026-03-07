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
        Schema::table('ventas', function (Blueprint $table) {
        // 1. Eliminamos la restricción actual [cite: 2026-02-21]
        $table->dropForeign(['user_id']); 
        
        // 2. La volvemos a crear permitiendo el borrado [cite: 2026-02-12]
        // Usamos 'cascade' o simplemente quitamos la restricción estricta
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade'); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
