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
        Schema::create('pwpedidoc', function (Blueprint $table) {
            $table->id('codpedido');
            $table->date('date'); // Nome da coluna 'date' pode ser problemático. Considere renomear para 'dtpedido'.
            
            $table->unsignedBigInteger('codcliente');
            $table->foreign('codcliente')->references('codcliente')->on('pwcliente');

            // A DDL presume a existência da tabela 'pwempregado' para o vendedor.
            $table->unsignedBigInteger('codvendedor');
            $table->foreign('codvendedor')->references('codempregado')->on('pwempregado');

            $table->decimal('mediadesc', 5, 2);
            $table->decimal('vltotal', 18, 4);
            $table->decimal('vldesconto', 18, 4);

            $table->unsignedBigInteger('codplpagamento');
            $table->foreign('codplpagamento')->references('codplpagamento')->on('pwplanopag');

            $table->string('obs', 250);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pwpedidoc');
    }
};
