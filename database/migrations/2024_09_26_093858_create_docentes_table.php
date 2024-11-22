<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->boolean('is_coordenador')->default(false);
            $table->foreignId('curso_id')->nullable()->constrained('cursos');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign(['departamento_id']);
            $table->dropForeign(['curso_id']);
        });
        
        Schema::dropIfExists('docentes');
    }
}; 