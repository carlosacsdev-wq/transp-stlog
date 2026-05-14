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
        Schema::dropIfExists('viagens');
        Schema::dropIfExists('carregamentos');
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esta operação é destrutiva e não pode ser revertida facilmente sem backup dos dados.
    }
};
