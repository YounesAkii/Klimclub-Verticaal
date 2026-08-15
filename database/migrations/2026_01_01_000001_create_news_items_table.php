<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_items', function (Blueprint $table) {
            $table->id();
            // Auteur van het nieuwsitem (one-to-many: user -> newsItems).
            // Bij het verwijderen van een gebruiker blijft het nieuws bestaan zonder auteur.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image_path');
            $table->string('excerpt', 500);
            $table->text('content');
            $table->timestamp('published_at');
            $table->timestamps();

            // De overzichtspagina sorteert altijd op publicatiedatum.
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_items');
    }
};
