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
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la colonne surname
            $table->dropColumn('surname');
            // Ajouter les colonnes nom et prenom
            $table->string('nom')->notNull()->after('id');
            $table->string('prenom')->notNull()->after('nom');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rétablir la colonne surname
            $table->string('surname')->unique()->after('id');
            // Supprimer les colonnes nom et prenom
            $table->dropColumn(['nom', 'prenom']);
        });
    }
};
