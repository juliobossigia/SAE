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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique(); 
            $table->date('data_nascimento');
            $table->string('cpf')->unique();
            $table->boolean('is_coordenador')->default(false);
            $table->unsignedBigInteger('departamento_id')->nullable(); // Adiciona a coluna departamento_id
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade'); // Define a chave estrangeira
            $table->unsignedBigInteger('curso_id')->nullable();//ISSO PARA COORDENADOR
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes',function(Blueprint $table){
        $table->dropForeign(['departamento_id']);
        $table->dropColumn('departamento_id');
        });
    }
};