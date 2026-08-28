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
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained('motoristas')->onDelete('cascade');
            $table->string('placa_cavalo');
            $table->string('placa_carreta');
            $table->string('nome_proprietario')->nullable();
            $table->string('endereco_proprietario')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('chassi')->nullable();
            $table->string('renavam')->nullable();
            $table->year('ano_fabricacao')->nullable();
            $table->year('ano_modelo')->nullable();
            $table->string('cidade_emissao')->nullable();
            $table->string('uf_emissao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
