<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->updateSqliteTable();
        } else {
            Schema::table('emergency_alerts', function (Blueprint $table) {
                $table->string('type')->nullable()->change();
            });
        }
    }
    
    private function updateSqliteTable(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        
        $alerts = DB::table('emergency_alerts')->get();
        
        Schema::dropIfExists('emergency_alerts_backup');
        
        // Create new table with nullable type
        Schema::create('emergency_alerts_backup', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type')->nullable();
            $table->string('priority')->default('low');
            $table->string('status')->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        
        // Copy data
        foreach ($alerts as $alert) {
            DB::table('emergency_alerts_backup')->insert([
                'id' => $alert->id,
                'title' => $alert->title,
                'message' => $alert->message,
                'type' => $alert->type,
                'priority' => $alert->priority ?? 'low',
                'status' => $alert->status ?? 'draft',
                'scheduled_at' => $alert->scheduled_at,
                'sent_at' => $alert->sent_at,
                'building_id' => $alert->building_id,
                'created_by' => $alert->created_by,
                'created_at' => $alert->created_at,
                'updated_at' => $alert->updated_at,
            ]);
        }
        
        Schema::dropIfExists('emergency_alerts');
        Schema::rename('emergency_alerts_backup', 'emergency_alerts');
        
        DB::statement('PRAGMA foreign_keys = ON');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->revertSqliteTable();
        } else {
            Schema::table('emergency_alerts', function (Blueprint $table) {
                $table->string('type')->change(); // Revert to non-nullable
            });
        }
    }
    
    private function revertSqliteTable(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        
        $alerts = DB::table('emergency_alerts')->get();
        
        Schema::dropIfExists('emergency_alerts_backup');
        
        // Create original table without nullable type
        Schema::create('emergency_alerts_backup', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type'); // Not nullable
            $table->string('priority')->default('low');
            $table->string('status')->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        
        // Copy data back, ensuring type is not null
        foreach ($alerts as $alert) {
            DB::table('emergency_alerts_backup')->insert([
                'id' => $alert->id,
                'title' => $alert->title,
                'message' => $alert->message,
                'type' => $alert->type ?? 'general', // Default value for potentially null types
                'priority' => $alert->priority ?? 'low',
                'status' => $alert->status ?? 'draft',
                'scheduled_at' => $alert->scheduled_at,
                'sent_at' => $alert->sent_at,
                'building_id' => $alert->building_id,
                'created_by' => $alert->created_by,
                'created_at' => $alert->created_at,
                'updated_at' => $alert->updated_at,
            ]);
        }
        
        Schema::dropIfExists('emergency_alerts');
        Schema::rename('emergency_alerts_backup', 'emergency_alerts');
        
        DB::statement('PRAGMA foreign_keys = ON');
    }
};
