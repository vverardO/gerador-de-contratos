<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('contracts', 'driver_license')) {
            return;
        }

        Schema::table('contracts', function (Blueprint $table) {
            $table->string('driver_license')->nullable()->after('driver_document');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('driver_license');
        });
    }
};
