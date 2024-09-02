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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('libelle')->unique(); // Ajout de la colonne 'libelle'
            $table->decimal('prix', 10, 2); // Ajout de la colonne 'prix' avec 2 décimales
            $table->integer('quantitestock'); // Ajout de la colonne 'quantitestock'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
