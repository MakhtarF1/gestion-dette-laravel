<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetteArticleTable extends Migration
{
    public function up()
    {
        Schema::create('dette_article', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('dette_id')->constrained()->onDelete('cascade');
            $table->decimal('prix', 10, 2); // Assurez-vous que cette ligne existe
            $table->integer('quantitestock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dette_article');
    }
}
