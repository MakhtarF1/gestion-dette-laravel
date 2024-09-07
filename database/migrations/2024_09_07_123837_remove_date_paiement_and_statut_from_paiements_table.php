<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDatePaiementAndStatusFromPaiementsTable extends Migration

{
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['date_paiement', 'status']);
        });
    }

    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dateTime('date_paiement')->nullable(); // Ajoutez les colonnes à nouveau si besoin
            $table->string('status')->nullable(); // Ajoutez les colonnes à nouveau si besoin
        });
    }
}
