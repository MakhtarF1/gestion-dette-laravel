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
        Schema::create('dette_paiement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dette_id')->constrained('dettes')->onDelete('cascade'); // Relation avec dettes
            $table->unsignedBigInteger('paiement_id')->constrained('paiements')->onDelete('cascade'); // Relation avec paiements
            $table->decimal('montant', 10, 2); // Montant du paiement associé à la dette
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dette_paiement');
    }
};
