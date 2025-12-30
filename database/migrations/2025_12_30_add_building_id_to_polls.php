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
        Schema::table('polls', function (Blueprint $table) {
            $table->foreignId('building_id')->nullable()->constrained('buildings')->onDelete('cascade');
            $table->string('category')->nullable(); // e.g., 'maintenance', 'amenity', 'general'
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active, scheduled, expired, closed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Building::class);
            $table->dropColumn(['building_id', 'category', 'description', 'status']);
        });
    }
};
