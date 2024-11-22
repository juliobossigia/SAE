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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->foreignId('aluno_id')->nullable()->constrained('alunos')->onDelete('cascade');
            $table->foreignId('turma_id')->nullable()->constrained('turmas')->onDelete('cascade');
            $table->enum('tipo', ['Advertência', 'Registro Disciplinar', 'Nota NAI', 'Registro Pedagogico']);
            $table->text('descricao');
            $table->foreignId('encaminhado_para')->constrained('setores')->onDelete('cascade');
            $table->foreignId('criado_por_id')->constrained('users')->onDelete('cascade');
            $table->boolean('agendamento')->default(false);
            $table->date('data_agendamento')->nullable();
            $table->time('hora_agendamento')->nullable();
            $table->string('participantes')->nullable();
            $table->foreignId('local_id')->nullable()->constrained('locais')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};