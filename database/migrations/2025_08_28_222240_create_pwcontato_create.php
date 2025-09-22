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
        Schema::create('pwcontato_create', function (Blueprint $table) {
            $table->id();
            $table->string('telefone', 15);
            $table->string('celular', 15);
            $table->string('fax', 15);
            $table->string('email');
            $table->string('email2')->nullable();
            $table->timestamps();
        });

        Schema::create('pwendereco_create', function (Blueprint $table) {
            $table->id();
            $table->string('logradouro', 100);
            $table->string('numero', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);
            $table->string('cidade', 50);
            $table->string('estado', 2);
            $table->string('cep', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwcontato_create');
        Schema::dropIfExists('pwendereco_create');
    }
};
