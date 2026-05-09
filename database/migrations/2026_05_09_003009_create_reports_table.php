<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Usuario que envía el reporte
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Descripción opcional del incendio
            $table->text('description')->nullable();

            // Coordenadas
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            // auto = ubicación automática
            // manual = ubicación ingresada por el usuario
            $table->string('location_type')->default('manual');

            // enviado = recién creado
            // visto = ya fue revisado
            $table->string('status')->default('enviado');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};