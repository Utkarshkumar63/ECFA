<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('event_date');
            $table->string('venue');
            $table->text('venue_address')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['Upcoming', 'Ongoing', 'Completed', 'Cancelled'])->default('Upcoming');
            $table->integer('max_participants')->nullable();
            $table->text('rules')->nullable();
            $table->string('event_image')->nullable();
            $table->boolean('is_registration_open')->default(true);
            $table->date('registration_end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
