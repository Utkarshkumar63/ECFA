<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->id();

             $table->foreignId('user_id')->constrained()->onDelete('cascade');

             $table->date('attendance_date');

             $table->enum('status', ['present', 'absent', 'leave'])->default('absent');

             $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['user_id', 'attendance_date']);

            $table->index('attendance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_attendances');
    }
};
