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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('building_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // payer
        $table->string('gateway')->nullable(); // e.g. razorpay
        $table->string('gateway_payment_id')->nullable();
        $table->decimal('amount', 10, 2)->default(0);
        $table->string('status')->default('pending'); // pending | success | failed
        $table->json('meta')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
