<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Reporte relacionado, puede ser null si luego quieres mensajes generales
            $table->foreignId('report_id')->nullable()->constrained()->nullOnDelete();

            // Usuario que recibirá o verá la notificación
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Título corto
            $table->string('title');

            // Mensaje completo
            $table->text('message');

            // false = no leído, true = leído
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};