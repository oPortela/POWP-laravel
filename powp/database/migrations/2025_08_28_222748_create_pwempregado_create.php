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
        Schema::create('pwempregado_create', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('cpf', 14)->unique();
            $table->date('data_nascimento');
            $table->date('data_admissao');
            $table->date('data_demissao')->nullable();
            $table->foreignId('contato_id')->constrained('pwcontato_create')->onDelete('cascade');
            $table->foreignId('endereco_id')->constrained('pwendereco_create')->onDelete('cascade');
            $table->string('cargo', 100);
            $table->string('salario', 10);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwempregado_create');
    }
};
