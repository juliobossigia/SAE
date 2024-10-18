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
        Schema::create('registro_pendentes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('cpf');
            $table->string('password');
            $table->enum('type', ['docente', 'servidor']); // Alterado de role para type
            $table->date('data_nascimento')->nullable(); // Para docentes
            $table->unsignedBigInteger('departamento_id')->nullable(); // Para docentes
            $table->unsignedBigInteger('setor_id')->nullable(); // Para servidores
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('set null');
            $table->foreign('setor_id')->references('id')->on('setores')->onDelete('set null');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_pendentes');
    }
};
