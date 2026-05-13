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
            $table->string('fabrica')->nullable()->after('numero_dt');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropColumn('fabrica');
        });
    }
};
