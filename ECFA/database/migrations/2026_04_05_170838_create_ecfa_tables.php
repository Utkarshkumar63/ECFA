<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcfaTables extends Migration
{
    public function up(): void
    {
        // 1. Events Table (Create if not exists)
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->date('event_date');
                $table->string('location');
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        // 2. Users Table
        // Agar users table nahi hai toh banayein, agar hai toh columns add karein
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('player');
                $table->string('phone')->nullable();
                $table->string('category')->nullable();
                $table->string('age_group')->nullable();
                $table->boolean('is_approved')->default(false);
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                // Check karke columns add karein taki error na aaye
                if (!Schema::hasColumn('users', 'role')) $table->string('role')->default('player');
                if (!Schema::hasColumn('users', 'phone')) $table->string('phone')->nullable();
                if (!Schema::hasColumn('users', 'category')) $table->string('category')->nullable();
                if (!Schema::hasColumn('users', 'is_approved')) $table->boolean('is_approved')->default(false);
            });
        }

        // 3. Achievements Table
        if (!Schema::hasTable('achievements')) {
            Schema::create('achievements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('medal');
                $table->timestamps();
            });
        }

        // 4. Learn Materials Table
        if (!Schema::hasTable('learn_materials')) {
            Schema::create('learn_materials', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('weapon');
                $table->string('file_path');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('learn_materials');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('events');
        // Users table drop nahi karenge kyunki wo default table ho sakti hai
    }
}
