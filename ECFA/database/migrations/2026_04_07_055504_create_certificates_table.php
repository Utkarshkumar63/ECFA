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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('cert_id')->unique(); // Unique Certificate ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Athlete ID
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Event ID
            $table->string('event_name'); // Name of the event
            $table->string('verification_hash'); // Security Hash for QR
            $table->date('issue_date'); // Date of issuance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
