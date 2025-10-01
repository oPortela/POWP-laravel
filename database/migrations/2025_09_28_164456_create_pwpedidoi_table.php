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
        Schema::create('pwpedidoi', function (Blueprint $table) {
            // Definição das colunas de chave estrangeira
            $table->unsignedBigInteger('codpedido');
            $table->foreign('codpedido')->references('codpedido')->on('pwpedidoc');

            $table->unsignedBigInteger('codproduto');
            $table->foreign('codproduto')->references('codproduto')->on('pwproduto');
            
            // Definição das colunas de dados
            $table->decimal('qtd', 18, 2);
            $table->decimal('desconto', 5, 2);
            $table->decimal('vlunitario', 18, 4);
            $table->decimal('vltotal', 18, 4);
            $table->timestamps();

            // Definição da chave primária composta
            $table->primary(['codpedido', 'codproduto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwpedidoi');
    }
};
