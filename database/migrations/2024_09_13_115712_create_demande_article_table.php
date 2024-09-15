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
        Schema::create('demande_article', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers la table 'demandes'
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            
            // Clé étrangère vers la table 'articles'
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            
            // Quantité de l'article dans cette demande
            $table->integer('quantite');
            
            // Optionnel : prix de l'article au moment de la demande (si nécessaire)
            $table->decimal('prix', 8, 2)->nullable();
            
            // Timestamps pour suivre les modifications
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_article');
    }
};
