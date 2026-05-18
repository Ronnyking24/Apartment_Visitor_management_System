<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql' && Schema::hasTable('tenants')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->foreignId('apartment_id')->nullable()->change();
            });
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
