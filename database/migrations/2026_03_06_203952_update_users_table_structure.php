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
    Schema::table('users', function (Blueprint $table) {
        // Renombramos 'name' a 'nombre'
        $table->renameColumn('name', 'nombre');
        
        // Agregamos nuestros campos personalizados
        $table->string('ap')->after('nombre'); // Apellido Paterno [cite: 2025-11-23]
        $table->string('am')->after('ap');     // Apellido Materno [cite: 2025-11-23]
        $table->string('username')->unique()->after('am'); // Usuario único [cite: 2025-11-23]
        $table->string('role')->default('user')->after('password'); // Rol de usuario

        // Eliminamos el email (ya que usaremos username)
        $table->dropColumn(['email', 'email_verified_at']);
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Código para revertir los cambios si es necesario
        $table->renameColumn('nombre', 'name');
        $table->dropColumn(['ap', 'am', 'username', 'role']);
        $table->string('email')->unique();
    });
}
};
