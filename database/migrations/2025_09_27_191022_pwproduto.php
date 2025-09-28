<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pwproduto', function (Blueprint $table) {
            $table->bigIncrements('codproduto'); // Chave primária
            $table->string('descricao', 200);
            $table->bigInteger('codfornec')->unsigned();
            $table->string('embalagem', 100);
            $table->string('ean', 13);
            $table->date('dtcadastro');

            // Chave estrangeira
            $table->foreign('codfornec')->references('codfornecedor')->on('pwfornecedor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
