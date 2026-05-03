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
        Schema::table('users', function (Blueprint $table) {
            // Mandatory Fields
            $table->string('aadhar_no')->after('experience');
            $table->string('aadhar_photo')->after('aadhar_no');
            $table->string('dob_photo')->after('aadhar_photo');

            // Optional Fields (Nullable)
            $table->string('passport_no')->nullable()->after('dob_photo');
            $table->string('passport_photo')->nullable()->after('passport_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'aadhar_no',
                'aadhar_photo',
                'dob_photo',
                'passport_no',
                'passport_photo'
            ]);
        });
    }
};
