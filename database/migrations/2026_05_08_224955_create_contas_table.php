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
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained('motoristas')->onDelete('cascade');
            $table->string('titular');
            $table->string('cpf_cnpj_titular');
            $table->string('banco');
            $table->string('agencia');
            $table->string('tipo_conta');
            $table->string('nro_conta');
            $table->string('tipo_chave')->nullable();
            $table->string('chave_pix')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
