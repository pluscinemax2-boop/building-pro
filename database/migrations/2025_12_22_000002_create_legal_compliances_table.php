<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('legal_compliances', function (Blueprint $table) {
            $table->id();
            $table->boolean('gdpr_enabled')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('legal_compliances');
    }
};