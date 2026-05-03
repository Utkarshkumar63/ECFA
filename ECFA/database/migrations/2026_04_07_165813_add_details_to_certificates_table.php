<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
{
    Schema::table('certificates', function (Blueprint $table) {
        // Agar column nahi hai, tabhi add karo
        if (!Schema::hasColumn('certificates', 'event_name')) {
            $table->string('event_name')->nullable()->after('user_id');
        }
        if (!Schema::hasColumn('certificates', 'medal_type')) {
            $table->string('medal_type')->nullable()->after('event_name');
        }
        if (!Schema::hasColumn('certificates', 'location')) {
            $table->string('location')->nullable()->after('medal_type');
        }
        if (!Schema::hasColumn('certificates', 'host_org')) {
            $table->string('host_org')->nullable()->after('location');
        }
    });
}
};
