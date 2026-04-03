<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('email')->unique();
            $table->string('phone', 10);
            $table->text('address');
            $table->enum('category', ['U-8', 'U-10', 'U-12', 'U-14', 'U-16', 'U-18', 'Senior']);
            $table->enum('event_type', ['Épée', 'Foil', 'Sabre'])->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
