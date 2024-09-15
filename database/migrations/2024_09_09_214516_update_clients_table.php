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
        Schema::table('clients', function (Blueprint $table) {
            // Supprimer les colonnes nom et prenom
            $table->dropColumn(['nom', 'prenom']);
            // Ajouter la colonne surname
            $table->string('surname')->unique()->notNull()->after('id');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Rétablir les colonnes nom et prenom
            $table->string('nom');
            $table->string('prenom');
            // Supprimer la colonne surname
            $table->dropColumn('surname');
        });
    }
};
