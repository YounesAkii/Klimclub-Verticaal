<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            // One-to-many: een lesgever (user) begeleidt veel trainingen.
            $table->foreignId('instructor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->enum('level', ['beginner', 'gevorderd', 'alle niveaus'])->default('alle niveaus');
            // Maximum aantal deelnemers; de inschrijving sluit zodra dit bereikt is.
            $table->unsignedSmallInteger('capacity')->default(12);
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->timestamps();

            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
