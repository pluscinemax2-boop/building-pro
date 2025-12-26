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
        Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();   // ✅ REQUIRED COLUMN
        $table->timestamps();
        });
    // RENAMED: This migration is now disabled to avoid conflict with Spatie's laravel-permission package.
    // If you need to migrate custom data, do so in a new migration after Spatie's tables are created.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
