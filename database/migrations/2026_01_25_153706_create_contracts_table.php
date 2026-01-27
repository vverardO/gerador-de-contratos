<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('driver_document');
            $table->string('driver_street');
            $table->string('driver_number');
            $table->string('driver_neighborhood');
            $table->string('driver_zip_code');
            $table->string('vehicle');
            $table->string('manufacturing_model');
            $table->string('license_plate');
            $table->string('chassis');
            $table->string('renavam');
            $table->string('owner_name');
            $table->string('owner_document');
            $table->string('value');
            $table->string('value_in_words');
            $table->string('today_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
