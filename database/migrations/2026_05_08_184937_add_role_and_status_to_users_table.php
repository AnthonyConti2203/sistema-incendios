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

            // Rol del usuario
            // civil = ciudadano normal
            // bombero = necesita aprobación
            // jefe = administrador principal
            $table->string('role')->default('civil');

            // Estado de aprobación
            // pendiente / aprobado / rechazado
            $table->string('status')->default('aprobado');

            // Teléfono opcional
            $table->string('phone')->nullable();

            // DNI opcional
            $table->string('dni')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'role',
                'status',
                'phone',
                'dni'
            ]);

        });
    }
};
