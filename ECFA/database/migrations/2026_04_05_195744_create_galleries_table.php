<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Isme humne title, url, aur description ke columns jode hain.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');            // Image ka naam
            $table->string('url');              // Cloudinary ka full secure URL
            $table->string('category')->nullable();
            $table->text('description')->nullable(); // Optional description (nullable matlab khali bhi chhod sakte hain)
            $table->timestamps();               // Created at aur Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
