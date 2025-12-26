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
        Schema::table('buildings', function (Blueprint $table) {
            if (!Schema::hasColumn('buildings', 'building_admin_id')) {
                $table->foreignId('building_admin_id')->nullable()->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('buildings', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            if (Schema::hasColumn('buildings', 'building_admin_id')) {
                $table->dropForeign(['building_admin_id']);
                $table->dropColumn('building_admin_id');
            }

            if (Schema::hasColumn('buildings', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

};
