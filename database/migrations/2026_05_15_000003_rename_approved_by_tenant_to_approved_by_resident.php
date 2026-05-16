<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visits') && Schema::hasColumn('visits', 'approved_by_tenant') && !Schema::hasColumn('visits', 'approved_by_resident')) {
            DB::statement('ALTER TABLE visits CHANGE approved_by_tenant approved_by_resident TINYINT(1) NOT NULL DEFAULT 0');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('visits') && Schema::hasColumn('visits', 'approved_by_resident') && !Schema::hasColumn('visits', 'approved_by_tenant')) {
            DB::statement('ALTER TABLE visits CHANGE approved_by_resident approved_by_tenant TINYINT(1) NOT NULL DEFAULT 0');
        }
    }
};