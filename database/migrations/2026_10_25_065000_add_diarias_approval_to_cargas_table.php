<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->unsignedInteger('diarias')->nullable();
            $table->timestamp('diarias_aprovadas_em')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropColumn(['diarias', 'diarias_aprovadas_em']);
        });
    }
};
