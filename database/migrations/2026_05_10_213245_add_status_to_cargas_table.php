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
        if (!Schema::hasColumn('cargas', 'status')) {
            Schema::table('cargas', function (Blueprint $table) {
                $table->string('status')->default('Pendente')->after('valor_frete');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('cargas', 'status')) {
            Schema::table('cargas', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
