<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Check if the table is called 'residents' (renamed) or 'tenants' (not renamed yet)
            $tableName = Schema::hasTable('residents') ? 'residents' : 'tenants';
            
            if (Schema::hasTable($tableName)) {
                if (Schema::hasColumn($tableName, 'apartment_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->foreignId('apartment_id')->nullable()->change();
                    });
                } elseif (Schema::hasColumn($tableName, 'apartment_room_id')) {
                    // If already renamed to apartment_room_id, modify that instead
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->unsignedBigInteger('apartment_room_id')->nullable()->change();
                    });
                }
            }

        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql' && Schema::hasTable('tenants')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->foreignId('apartment_id')->nullable(false)->change();
            });
        }
    }
};
