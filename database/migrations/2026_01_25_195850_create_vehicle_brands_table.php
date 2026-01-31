<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_brands', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        $createdAt = now();
        $updatedAt = now();

        DB::table('vehicle_brands')
            ->insert([
                ['title' => 'Chevrolet', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Volkswagen', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Renault', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Fiat', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Hyundai', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Toyota', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Ford', 'created_at' => $createdAt, 'updated_at' => $updatedAt],
            ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_brands');
    }
};
