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
    Schema::create('pwendereco', function (Blueprint $table) {
            $table->bigIncrements('codendereco'); // Chave primária
            $table->string('logradouro', 200);
            $table->string('numero', 10);
            $table->string('cep', 9);
            $table->string('bairro', 80);
            $table->string('cidade', 50);
            $table->string('pais', 2)->nullable(); // Campo opcional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('pwendereco');
    }
};
