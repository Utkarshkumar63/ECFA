<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('galleries', function (Blueprint $table) {
        if (!Schema::hasColumn('galleries', 'category')) {
            $table->string('category')->nullable()->after('description');
        }
    });
}

public function down(): void
{
    Schema::table('galleries', function (Blueprint $table) {
        if (Schema::hasColumn('galleries', 'category')) {
            $table->dropColumn('category');
        }
    });
}
};
