<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->string('nome_proprietario')->nullable();
            $table->string('endereco_proprietario')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('chassi')->nullable();
            $table->string('renavam')->nullable();
            $table->year('ano_fabricacao')->nullable();
            $table->year('ano_modelo')->nullable();
            $table->string('cidade_emissao')->nullable();
            $table->string('uf_emissao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn([
                'nome_proprietario', 'endereco_proprietario', 'cidade', 'uf', 'chassi', 'renavam',
                'ano_fabricacao', 'ano_modelo', 'cidade_emissao', 'uf_emissao',
            ]);
        });
    }
};