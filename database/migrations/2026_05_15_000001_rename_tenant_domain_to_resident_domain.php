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
            // Skip MySQL-specific ALTER/ENUM statements when running on SQLite (tests).
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (Schema::hasTable('apartments') && !Schema::hasTable('apartment_rooms')) {
            Schema::rename('apartments', 'apartment_rooms');
        }

        if (Schema::hasTable('tenants') && !Schema::hasTable('residents')) {
            Schema::rename('tenants', 'residents');
        }

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'apartment_id') && !Schema::hasColumn('residents', 'apartment_room_id')) {
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY tenants_user_id_foreign');
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY tenants_apartment_id_foreign');
            DB::statement('ALTER TABLE residents CHANGE apartment_id apartment_room_id BIGINT UNSIGNED NULL');
            Schema::table('residents', function (Blueprint $table): void {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('apartment_room_id')->references('id')->on('apartment_rooms')->nullOnDelete();
            });
        }

        if (Schema::hasTable('visits') && Schema::hasColumn('visits', 'tenant_id') && !Schema::hasColumn('visits', 'resident_id')) {
            DB::statement('ALTER TABLE visits DROP FOREIGN KEY visits_tenant_id_foreign');
            DB::statement('ALTER TABLE visits CHANGE tenant_id resident_id BIGINT UNSIGNED NOT NULL');
            Schema::table('visits', function (Blueprint $table): void {
                $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
            });
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard', 'tenant', 'resident') NOT NULL DEFAULT 'resident'");
        DB::table('users')->where('role', 'tenant')->update(['role' => 'resident']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard', 'resident') NOT NULL DEFAULT 'resident'");

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            // Skip MySQL-specific rollbacks when not using MySQL.
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard', 'tenant', 'resident') NOT NULL DEFAULT 'tenant'");
        DB::table('users')->where('role', 'resident')->update(['role' => 'tenant']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard', 'tenant') NOT NULL DEFAULT 'tenant'");

        if (Schema::hasTable('visits') && Schema::hasColumn('visits', 'resident_id') && !Schema::hasColumn('visits', 'tenant_id')) {
            DB::statement('ALTER TABLE visits DROP FOREIGN KEY visits_resident_id_foreign');
            DB::statement('ALTER TABLE visits CHANGE resident_id tenant_id BIGINT UNSIGNED NOT NULL');
            Schema::table('visits', function (Blueprint $table): void {
                $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'apartment_room_id') && !Schema::hasColumn('residents', 'apartment_id')) {
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY residents_user_id_foreign');
            DB::statement('ALTER TABLE residents DROP FOREIGN KEY residents_apartment_room_id_foreign');
            DB::statement('ALTER TABLE residents CHANGE apartment_room_id apartment_id BIGINT UNSIGNED NULL');
            Schema::table('residents', function (Blueprint $table): void {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('apartment_id')->references('id')->on('apartments')->nullOnDelete();
            });
        }

        if (Schema::hasTable('residents') && !Schema::hasTable('tenants')) {
            Schema::rename('residents', 'tenants');
        }

        if (Schema::hasTable('apartment_rooms') && !Schema::hasTable('apartments')) {
            Schema::rename('apartment_rooms', 'apartments');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};