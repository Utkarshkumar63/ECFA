<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('medal', ['Gold', 'Silver', 'Bronze', 'Certificate', 'Participation'])->default('Participation');
            $table->enum('level', ['Local', 'Regional', 'State', 'National', 'International'])->default('Local');
            $table->date('achievement_date');
            $table->string('event_name');
            $table->string('certificate_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
