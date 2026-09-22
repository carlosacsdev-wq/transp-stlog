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
        Schema::create('motoristas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('apelido')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('nome_mae');
            $table->string('nome_pai')->nullable();
            $table->string('rg')->nullable();
            $table->date('data_emissao_rg')->nullable();
            $table->string('cpf')->unique();
            $table->string('cnh')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('telefone')->nullable();
            $table->string('contato_pessoal1')->nullable();
            $table->string('contato_pessoal2')->nullable();
            $table->string('contato_pessoal3')->nullable();
            $table->string('contato_empresa1')->nullable();
            $table->string('contato_empresa2')->nullable();
            $table->string('contato_empresa3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motoristas');
    }
};
