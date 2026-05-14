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
            $table->date('data_pagamento')->nullable()->after('valor_frete');
            $table->decimal('valor_adiantamento', 10, 2)->nullable()->after('data_pagamento');
            $table->decimal('valor_saldo', 10, 2)->nullable()->after('valor_adiantamento');
            $table->string('status_pagamento')->default('Pendente')->after('valor_saldo');
        });

        Schema::dropIfExists('pagamentos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropColumn(['data_pagamento', 'valor_adiantamento', 'valor_saldo', 'status_pagamento']);
        });

        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->nullable()->constrained('motoristas')->onDelete('cascade');
            $table->foreignId('veiculo_id')->nullable()->constrained('veiculos')->onDelete('cascade');
            $table->string('cte');
            $table->string('dt');
            $table->date('data_pagamento');
            $table->decimal('valor_frete', 10, 2);
            $table->decimal('valor_adiantamento', 10, 2);
            $table->decimal('saldo_frete', 10, 2);
            $table->timestamps();
        });
    }
};
