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
        Schema::create('programacaos', function (Blueprint $table) {
            $table->id();
            $table->string('DT');
            $table->date('Data_Carreg');
            $table->date('Data_Descarreg');
            $table->string('Fabrica_Carreg');
            $table->string('Cliente_Destino');
            $table->string('Cidade_Destino');
            $table->date('Agend_Descarreg');
            $table->string('Motorista'); // aqui precisa ser um campo select
            $table->enum('Status', ['Pendente', 'Em Andamento', 'Comprometido', 'Cancelado'])->default('Pendente');
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
