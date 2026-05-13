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
        Schema::create('carregamentos', function (Blueprint $table) {
            $table->id();
            $table->string('DT');
            $table->date('Data_Carreg');
            $table->string('Fabrica_Carreg');
            $table->string('CTe');
            $table->string('Cliente_Destino');
            $table->string('Cidade_Destino');
            $table->date('Agend_Descarreg');
            $table->string('Motorista');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programacaos');
    }
};
