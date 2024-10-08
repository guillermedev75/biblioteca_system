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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('estoque_id');
            $table->date('data_emprestimo');
            $table->date('data_devolucao')->nullable()->change();
            $table->date('data_limite');
            $table->timestamps();

            $table->foreign('estoque_id')->references('id')->on('estoques')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprestimos', function (Blueprint $table) {
            $table->dropForeign(['estoque_id']);
            $table->dropForeign(['cliente_id']);
        });
    }
};
