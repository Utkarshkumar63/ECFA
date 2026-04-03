<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('email');
            $table->string('phone', 10);
            $table->text('address');
            $table->enum('category', ['U-8', 'U-10', 'U-12', 'U-14', 'U-16', 'U-18', 'Senior']);
            $table->enum('event_type', ['Épée', 'Foil', 'Sabre']);
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Composite unique key: email + event_id
            $table->unique(['email', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
