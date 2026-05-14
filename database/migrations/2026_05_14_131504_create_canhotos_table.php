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
        Schema::create('canhotos', function (Blueprint $table) {
            $table->id();
            $table->string('cte');
            $table->string('dt');
            $table->string('nome_motorista');
            $table->string('placa_cavalo');
            $table->string('placa_carreta');
            $table->string('status'); // esse status será pendente e entregue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canhotos');
    }
};
