<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->enum('status', ['Registered', 'Participated', 'Disqualified', 'Withdrew'])->default('Registered');
            $table->string('position')->nullable(); // 1st, 2nd, 3rd, etc.
            $table->timestamps();
            
            $table->unique(['event_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
