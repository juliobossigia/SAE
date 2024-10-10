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
        Schema::create('locais', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('predio_id'); // Chave estrangeira para Prédio
        $table->string('sala');
        $table->timestamps();

        // Definir a relação com o prédio
        $table->foreign('predio_id')->references('id')->on('predios')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local');
    }
};
