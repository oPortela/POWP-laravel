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
        Schema::create('pwfornecedor', function (Blueprint $table) {
            $table->bigIncrements('codfornecedor'); // Chave primária
            $table->string('nome', 200);
            $table->string('fantasia', 200);
            $table->string('cnpj', 14)->unique(); // Restrição de unicidade
            $table->date('dtcadastro');
            $table->string('email', 100);
            $table->bigInteger('codendereco')->unsigned();
            $table->bigInteger('codtelefone')->unsigned();
            $table->string('representante', 100);

            // Chaves estrangeiras
            $table->foreign('codendereco')->references('codendereco')->on('pwendereco');
            // Linha correta
            $table->foreign('codtelefone')->references('codtelefone')->on('pwtelefones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwfornecedor');
    }
};
