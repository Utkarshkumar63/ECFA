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
        Schema::table('contacts', function (Blueprint $table) {
            // Admin ka reply save karne ke liye
            $table->text('reply_message')->nullable()->after('message');
            // Reply kab bheja gaya uski timing ke liye
            $table->timestamp('replied_at')->nullable()->after('reply_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Rollback karne par columns delete ho jayenge
            $table->dropColumn(['reply_message', 'replied_at']);
        });
    }
};
