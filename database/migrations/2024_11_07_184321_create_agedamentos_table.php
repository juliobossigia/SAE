<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained()->onDelete('cascade');
            $table->date('data_agendamento');
            $table->time('hora_agendamento');
            $table->string('participantes')->nullable();
            $table->foreignId('local_id')->nullable()->constrained('locais');
            $table->enum('status', ['Pendente', 'Confirmado', 'Cancelado', 'Realizado'])->default('Pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};