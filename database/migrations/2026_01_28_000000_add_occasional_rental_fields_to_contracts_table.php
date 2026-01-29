<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedSmallInteger('quantity_days')->nullable()->after('today_date');
            $table->string('start_date')->nullable()->after('quantity_days');
            $table->string('end_date')->nullable()->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['quantity_days', 'start_date', 'end_date']);
        });
    }
};
