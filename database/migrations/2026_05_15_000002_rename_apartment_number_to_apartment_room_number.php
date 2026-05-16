<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('apartment_rooms') && Schema::hasColumn('apartment_rooms', 'apartment_number') && !Schema::hasColumn('apartment_rooms', 'apartment_room_number')) {
            DB::statement('ALTER TABLE apartment_rooms CHANGE apartment_number apartment_room_number VARCHAR(255) NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('apartment_rooms') && Schema::hasColumn('apartment_rooms', 'apartment_room_number') && !Schema::hasColumn('apartment_rooms', 'apartment_number')) {
            DB::statement('ALTER TABLE apartment_rooms CHANGE apartment_room_number apartment_number VARCHAR(255) NOT NULL');
        }
    }
};