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
        Schema::create('pwcliente_create', function (Blueprint $table) {
            $table->id();
            $table->date('data_cadastro');
            $table->char('tipo_pessoa', 1);
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->check('tipo_pessoa IN ("F", "J")');
        });

        Schema::create('pwcliente_fisico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('pwcliente_create')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('sobrenome', 100);
            $table->string('cpf', 14)->unique();
            $table->date('data_nascimento');
            $table->string('rg', 20)->nullable();
            $table->string('orgao_expedidor', 20)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->timestamps();
            $table->check('sexo IN ("M", "F", "O")');
        });

        Schema::create('pwcliente_juridico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('pwcliente_create')->onDelete('cascade');
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
        Schema::dropIfExists('pwcliente_create');
        Schema::dropIfExists('pwcliente_fisico');
        Schema::dropIfExists('pwcliente_juridico');
    }
};
