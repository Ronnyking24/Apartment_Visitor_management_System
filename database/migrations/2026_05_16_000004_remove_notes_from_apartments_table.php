<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            if (Schema::hasColumn('apartments', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }

    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            if (! Schema::hasColumn('apartments', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }
};
