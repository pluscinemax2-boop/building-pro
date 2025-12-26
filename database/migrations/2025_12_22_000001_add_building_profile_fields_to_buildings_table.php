<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuildingProfileFieldsToBuildingsTable extends Migration
{
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            if (!Schema::hasColumn('buildings', 'country')) {
                $table->string('country')->nullable();
            }
            if (!Schema::hasColumn('buildings', 'state')) {
                $table->string('state')->nullable();
            }
            if (!Schema::hasColumn('buildings', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('buildings', 'zip')) {
                $table->string('zip')->nullable();
            }
            if (!Schema::hasColumn('buildings', 'emergency_phone')) {
                $table->string('emergency_phone')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn(['country', 'state', 'city', 'zip', 'emergency_phone']);
        });
    }
}
