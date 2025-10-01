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
        Schema::create('pwcliente', function (Blueprint $table) {
            // Usar id() é a forma mais moderna de definir a chave primária.
            $table->id('codcliente');
            $table->date('data_cadastro');
            $table->enum('tipo_pessoa', ["F", "J"]);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        Schema::create('pwcliente_fisico', function (Blueprint $table) {
            $table->id();
            // CORREÇÃO APLICADA AQUI
            $table->foreignId('codcliente')->constrained(table: 'pwcliente', column: 'codcliente')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('sobrenome', 100);
            $table->string('cpf', 14)->unique();
            $table->date('data_nascimento');
            $table->string('rg', 20)->nullable();
            $table->string('orgao_expedidor', 20)->nullable();
            $table->enum('sexo', ['M', 'F', 'O'])->nullable();
            $table->timestamps();
        });

        Schema::create('pwcliente_juridico', function (Blueprint $table) {
            $table->id();
            // CORREÇÃO APLICADA AQUI
            $table->foreignId('codcliente')->constrained(table: 'pwcliente', column: 'codcliente')->onDelete('cascade');
            $table->string('razao_social', 150);
            $table->string('nome_fantasia', 100)->nullable();
            $table->string('cnpj', 18)->unique();
            $table->string('inscricao_estadual', 20)->nullable();
            $table->string('inscricao_municipal', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwcliente_juridico');
        Schema::dropIfExists('pwcliente_fisico');
        Schema::dropIfExists('pwcliente_create');
    }
};