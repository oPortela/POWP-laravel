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
        Schema::create('pwplanos', function (Blueprint $table) {
            $table->bigIncrements('codplano'); // Chave primária
            $table->string('nome', 100)->unique();
            $table->text('descricao')->nullable();
            $table->decimal('valor', 8, 2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwplanos');
    }
};