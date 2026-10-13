<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('motoristas', function (Blueprint $table) {
            $table->string('apelido')->nullable()->after('nome');
            $table->date('data_nascimento')->nullable()->after('apelido');
            $table->string('nome_mae')->default('')->after('data_nascimento');
            $table->string('nome_pai')->nullable()->after('nome_mae');
            $table->string('rg')->nullable()->after('nome_pai');
            $table->date('data_emissao_rg')->nullable()->after('rg');
            $table->string('endereco')->nullable()->after('cnh');
            $table->string('bairro')->nullable()->after('endereco');
            $table->string('cidade')->nullable()->after('bairro');
            $table->string('estado')->nullable()->after('cidade');
            $table->string('contato_pessoal1')->nullable()->after('telefone');
            $table->string('contato_pessoal2')->nullable()->after('contato_pessoal1');
            $table->string('contato_pessoal3')->nullable()->after('contato_pessoal2');
            $table->string('contato_empresa1')->nullable()->after('contato_pessoal3');
            $table->string('contato_empresa2')->nullable()->after('contato_empresa1');
            $table->string('contato_empresa3')->nullable()->after('contato_empresa2');
        });
    }

    public function down(): void
    {
        Schema::table('motoristas', function (Blueprint $table) {
            $table->dropColumn([
                'apelido', 'data_nascimento', 'nome_mae', 'nome_pai', 'rg', 'data_emissao_rg',
                'endereco', 'bairro', 'cidade', 'estado',
                'contato_pessoal1', 'contato_pessoal2', 'contato_pessoal3',
                'contato_empresa1', 'contato_empresa2', 'contato_empresa3',
            ]);
        });
    }
};