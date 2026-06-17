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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('nome_popular');
            $table->string('especie');

            // Taxonomia
            $table->string('reino');
            $table->string('filo');
            $table->string('classe');
            $table->string('ordem');
            $table->string('familia');
            $table->string('genero');

            // Localização
            $table->string('regiao');
            $table->string('habitat');

            // Características físicas
            $table->string('porte');
            $table->string('epoca_reprodutiva');

            // Informações detalhadas (texto longo)
            $table->text('beneficios');
            $table->text('maleficios');
            $table->text('poda');
            $table->text('curiosidades')->nullable();
            $table->text('plantas_companheiras');

            // Status e mídia
            $table->boolean('ameacada_extincao')->default(false);
            $table->string('imagem_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
