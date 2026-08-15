<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Koppeltabel voor de many-to-many relatie tussen gebruikers en trainingen:
     * een gebruiker schrijft zich in voor meerdere trainingen en een training
     * heeft meerdere ingeschreven deelnemers.
     */
    public function up(): void
    {
        Schema::create('training_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            // Extra kolom op de pivot: wanneer de inschrijving geplaatst werd.
            $table->timestamp('registered_at');
            $table->timestamps();

            // Een gebruiker kan zich maar één keer inschrijven per training.
            $table->unique(['user_id', 'training_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_user');
    }
};
