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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname')->unique(); // Champ surname ajouté
            $table->enum('etat', ['actif', 'inactif'])->default('actif');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('login')->unique();
            $table->string('password')->check('LENGTH(password) >= 8 AND password REGEXP BINARY \'[A-Z]\' AND password REGEXP BINARY \'[a-z]\' AND password REGEXP BINARY \'[0-9]\' AND password REGEXP BINARY \'[!@#$%^&*()_+{}\[\]:;"\'<>?,./]\'');
            $table->string('photo'); // Champ photo obligatoire
            $table->string('qr_code')->nullable(); // Champ qr_code optionnel
            $table->enum('etat_photo', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
