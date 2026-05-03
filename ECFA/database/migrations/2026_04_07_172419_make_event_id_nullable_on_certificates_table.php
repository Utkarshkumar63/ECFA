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
        Schema::table('certificates', function (Blueprint $table) {
            // event_id ko optional (nullable) bana rahe hain
            // Note: Agar foreign key constraints hain toh nullable() change kaam karega
            $table->unsignedBigInteger('event_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Wapas mandatory banane ke liye
            $table->unsignedBigInteger('event_id')->nullable(false)->change();
        });
    }
};
