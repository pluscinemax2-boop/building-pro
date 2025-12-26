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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('email_payment_confirmations')->default(true);
            $table->boolean('email_subscription_updates')->default(true);
            $table->boolean('email_complaint_updates')->default(true);
            $table->boolean('email_maintenance_updates')->default(true);
            $table->boolean('email_announcements')->default(true);
            $table->boolean('email_emergency_alerts')->default(true);
            $table->boolean('email_forum_replies')->default(true);
            $table->boolean('digest_weekly')->default(false);
            $table->boolean('digest_monthly')->default(false);
            $table->timestamp('last_digest_sent_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
            $table->index(['user_id', 'created_at']);
        });

        // Add email_notifications_enabled to users table if not exists
        if (!Schema::hasColumn('users', 'email_notifications_enabled')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('email_notifications_enabled')->default(true)->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
        
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email_notifications_enabled')) {
                $table->dropColumn('email_notifications_enabled');
            }
        });
    }
};
