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
        Schema::table('emergency_alerts', function (Blueprint $table) {
            $table->string('priority')->default('low');
            $table->string('status')->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('created_by');
            
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_alerts', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
            $table->dropForeign(['created_by']);
            
            $table->dropColumn(['priority', 'status', 'scheduled_at', 'sent_at', 'building_id', 'created_by']);
        });
    }
};
