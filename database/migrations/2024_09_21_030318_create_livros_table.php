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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('editora_id');
            $table->integer('ano');
            $table->string('isbn')->unique();
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('autor_id')->references('id')->on('autors')->onDelete('cascade');
            $table->foreign('editora_id')->references('id')->on('editoras')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
