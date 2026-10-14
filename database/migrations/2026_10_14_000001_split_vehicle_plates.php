<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->string('placa')->nullable();
            $table->string('tipo')->nullable();
        });

        DB::table('veiculos')->orderBy('id')->get()->each(function ($veiculo) {
            $placaCarreta = $veiculo->placa_carreta;

            DB::table('veiculos')->where('id', $veiculo->id)->update([
                'placa' => $veiculo->placa_cavalo,
                'tipo' => 'cavalo',
            ]);

            if ($placaCarreta) {
                DB::table('veiculos')->insert([
                    'motorista_id' => $veiculo->motorista_id,
                    'placa_cavalo' => $placaCarreta,
                    'placa_carreta' => $placaCarreta,
                    'tenant_id' => $veiculo->tenant_id,
                    'placa' => $placaCarreta,
                    'tipo' => 'carreta',
                    'created_at' => $veiculo->created_at,
                    'updated_at' => $veiculo->updated_at,
                ]);
            }
        });

        Schema::table('veiculos', function (Blueprint $table) {
            $table->string('placa')->nullable(false)->change();
            $table->string('tipo')->nullable(false)->change();
        });

        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn(['placa_cavalo', 'placa_carreta']);
        });
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->string('placa_cavalo')->nullable();
            $table->string('placa_carreta')->nullable();
        });

        DB::table('veiculos')->orderBy('id')->get()->each(function ($veiculo) {
            $column = $veiculo->tipo === 'carreta' ? 'placa_carreta' : 'placa_cavalo';
            DB::table('veiculos')->where('id', $veiculo->id)->update([
                $column => $veiculo->placa,
            ]);
        });

        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn(['placa', 'tipo']);
        });
    }
};