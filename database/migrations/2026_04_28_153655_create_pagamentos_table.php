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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('cte');
            $table->string('dt');
            $table->date('data_pagamento');
            $table->decimal('valor_frete', 10, 2);
            $table->string('nome_motorista');
            $table->decimal('valor_adiantamento', 10, 2);
            $table->decimal('saldo_frete', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
