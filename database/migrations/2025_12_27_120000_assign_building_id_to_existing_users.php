<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Example: Assign building_id = 1 to user id 3, building_id = 2 to user id 4
        // Update these values as per your actual mapping
        DB::table('users')->where('id', 3)->update(['building_id' => 1]);
        DB::table('users')->where('id', 4)->update(['building_id' => 2]);
    }

    public function down()
    {
        // Optionally revert
        DB::table('users')->whereIn('id', [3,4])->update(['building_id' => null]);
    }
};
