<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Identifiant unique de la notification
            $table->string('type'); // Type de notification (peut être utilisé pour les différentes notifications)
            $table->morphs('notifiable'); // Pour les notifications polymorphiques (peut être lié à différents modèles)
            $table->text('data'); // Données de la notification (JSON ou texte)
            $table->timestamp('read_at')->nullable(); // Timestamp pour les notifications lues
            $table->unsignedBigInteger('client_id')->nullable(); // Client associé à la notification
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null'); // Clé étrangère avec suppression en cascade

            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['client_id']); // Supprimer la contrainte de clé étrangère
        });

        Schema::dropIfExists('notifications'); // Supprimer la table notifications
    }
};
