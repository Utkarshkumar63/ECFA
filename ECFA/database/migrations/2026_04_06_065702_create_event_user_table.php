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
        Schema::create('event_user', function (Blueprint $table) {
            $table->id();

            // Link to the Users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Link to the Events table
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // SECURITY: Prevent duplicate registrations at the database level
            $table->unique(['user_id', 'event_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
    }
};
