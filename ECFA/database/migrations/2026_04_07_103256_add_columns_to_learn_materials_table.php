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
        Schema::table('learn_materials', function (Blueprint $table) {
            // Check karein agar columns pehle se nahi hain, tabhi add karein
            if (!Schema::hasColumn('learn_materials', 'event_id')) {
                $table->unsignedBigInteger('event_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('learn_materials', 'content')) {
                $table->text('content')->nullable()->after('title');
            }
            if (!Schema::hasColumn('learn_materials', 'material_type')) {
                $table->string('material_type')->nullable()->after('weapon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learn_materials', function (Blueprint $table) {
            $table->dropColumn(['event_id', 'content', 'material_type']);
        });
    }
};
