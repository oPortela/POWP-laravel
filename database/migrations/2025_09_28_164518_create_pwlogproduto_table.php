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
        Schema::create('pwlogproduto', function (Blueprint $table) {
            // id bigserial PRIMARY KEY
            $table->id();

            // codproduto bigint NOT NULL
            $table->bigInteger('codproduto');

            // acao character varying(10) NOT NULL
            $table->string('acao', 10);

            // usuario character varying(100) NOT NULL
            $table->string('usuario', 100);

            // descricao_old character varying(200)
            $table->string('descricao_old', 200)->nullable();

            // descricao_new character varying(200)
            $table->string('descricao_new', 200)->nullable();

            // dtacao timestamp ... DEFAULT now()
            $table->timestamp('dtacao')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwlogproduto');
    }
};
