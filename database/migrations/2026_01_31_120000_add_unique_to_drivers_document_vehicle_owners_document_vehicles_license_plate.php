<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->unique('document');
        });

        Schema::table('vehicle_owners', function (Blueprint $table) {
            $table->unique('document');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->unique('license_plate');
        });
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropUnique(['document']);
        });

        Schema::table('vehicle_owners', function (Blueprint $table) {
            $table->dropUnique(['document']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropUnique(['license_plate']);
        });
    }
};
