<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (Schema::hasTable('apartment_rooms') && !Schema::hasTable('apartments')) {
            Schema::rename('apartment_rooms', 'apartments');
        }

        if (Schema::hasTable('apartments') && Schema::hasColumn('apartments', 'apartment_room_number') && !Schema::hasColumn('apartments', 'apartment_number')) {
            DB::statement('ALTER TABLE apartments CHANGE apartment_room_number apartment_number VARCHAR(255) NOT NULL');
        }

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'apartment_room_id') && !Schema::hasColumn('residents', 'apartment_id')) {
            // drop existing foreign keys if present
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY IF EXISTS residents_user_id_foreign');
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY IF EXISTS residents_apartment_room_id_foreign');
            DB::statement('ALTER TABLE residents CHANGE apartment_room_id apartment_id BIGINT UNSIGNED NULL');
            Schema::table('residents', function (Blueprint $table): void {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('apartment_id')->references('id')->on('apartments')->nullOnDelete();
            });
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'apartment_id') && !Schema::hasColumn('residents', 'apartment_room_id')) {
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY IF EXISTS residents_user_id_foreign');
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY IF EXISTS residents_apartment_id_foreign');
            DB::statement('ALTER TABLE residents CHANGE apartment_id apartment_room_id BIGINT UNSIGNED NULL');
            Schema::table('residents', function (Blueprint $table): void {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('apartment_room_id')->references('id')->on('apartment_rooms')->nullOnDelete();
            });
        }

        if (Schema::hasTable('apartments') && Schema::hasColumn('apartments', 'apartment_number') && !Schema::hasColumn('apartments', 'apartment_room_number')) {
            DB::statement('ALTER TABLE apartments CHANGE apartment_number apartment_room_number VARCHAR(255) NOT NULL');
        }

        if (Schema::hasTable('apartments') && !Schema::hasTable('apartment_rooms')) {
            Schema::rename('apartments', 'apartment_rooms');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
