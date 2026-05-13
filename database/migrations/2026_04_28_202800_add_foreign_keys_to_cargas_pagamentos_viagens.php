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
        // Cargas: adicionar FK para motorista e veiculo
        Schema::table('cargas', function (Blueprint $table) {
            $table->foreignId('motorista_id')->nullable()->after('id')->constrained('motoristas')->onDelete('cascade');
            $table->foreignId('veiculo_id')->nullable()->after('motorista_id')->constrained('veiculos')->onDelete('cascade');
        });

        // Pagamentos: substituir nome_motorista por FK motorista_id e veiculo_id
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->foreignId('motorista_id')->nullable()->after('id')->constrained('motoristas')->onDelete('cascade');
            $table->foreignId('veiculo_id')->nullable()->after('motorista_id')->constrained('veiculos')->onDelete('cascade');
            $table->dropColumn('nome_motorista');
        });

        // Viagens: substituir nome_motorista por FK motorista_id e veiculo_id
        Schema::table('viagens', function (Blueprint $table) {
            $table->foreignId('motorista_id')->nullable()->after('id')->constrained('motoristas')->onDelete('cascade');
            $table->foreignId('veiculo_id')->nullable()->after('motorista_id')->constrained('veiculos')->onDelete('cascade');
            $table->dropColumn('nome_motorista');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropForeign(['motorista_id']);
            $table->dropForeign(['veiculo_id']);
            $table->dropColumn(['motorista_id', 'veiculo_id']);
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropForeign(['motorista_id']);
            $table->dropForeign(['veiculo_id']);
            $table->dropColumn(['motorista_id', 'veiculo_id']);
            $table->string('nome_motorista')->after('valor_frete');
        });

        Schema::table('viagens', function (Blueprint $table) {
            $table->dropForeign(['motorista_id']);
            $table->dropForeign(['veiculo_id']);
            $table->dropColumn(['motorista_id', 'veiculo_id']);
            $table->string('nome_motorista')->after('data_hora_descarga');
        });
    }
};
