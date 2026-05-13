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
        Schema::table('cargas', function (Blueprint $table) {
            // Alterando os campos existentes para datetime
            $table->dateTime('data_carregamento')->change();
            $table->dateTime('data_agendamento_descarga')->change();
            
            // Adicionando novos campos para controle de viagem
            $table->dateTime('data_hora_chegada')->nullable()->after('data_agendamento_descarga');
            $table->dateTime('data_hora_descarga')->nullable()->after('data_hora_chegada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->date('data_carregamento')->change();
            $table->date('data_agendamento_descarga')->change();
            $table->dropColumn(['data_hora_chegada', 'data_hora_descarga']);
        });
    }
};
