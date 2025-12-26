<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // $table->string('priority')->default('Medium'); // Already exists, so skip to avoid error
            // $table->string('image')->nullable(); // Already exists, so skip to avoid error
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['priority', 'image']);
        });
    }
};
