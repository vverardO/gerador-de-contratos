<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_brand_id')->constrained('vehicle_brands');
            $table->string('title');
            $table->timestamps();
        });

        $volkswagenBrand = DB::table('vehicle_brands')->where('title', 'Volkswagen')->first();
        $fiatBrand = DB::table('vehicle_brands')->where('title', 'Fiat')->first();
        $renaultBrand = DB::table('vehicle_brands')->where('title', 'Renault')->first();
        $hyundaiBrand = DB::table('vehicle_brands')->where('title', 'Hyundai')->first();
        $toyotaBrand = DB::table('vehicle_brands')->where('title', 'Toyota')->first();
        $fordBrand = DB::table('vehicle_brands')->where('title', 'Ford')->first();
        $chevroletBrand = DB::table('vehicle_brands')->where('title', 'Chevrolet')->first();

        $createdAt = now();
        $updatedAt = now();

        DB::table('vehicle_models')
            ->insert([
                ['title' => 'Mobi', 'vehicle_brand_id' => $fiatBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Voyage', 'vehicle_brand_id' => $volkswagenBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Kwid', 'vehicle_brand_id' => $renaultBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'HB20', 'vehicle_brand_id' => $hyundaiBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Etios', 'vehicle_brand_id' => $toyotaBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Ka', 'vehicle_brand_id' => $fordBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Onix', 'vehicle_brand_id' => $chevroletBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Gol', 'vehicle_brand_id' => $volkswagenBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Polo', 'vehicle_brand_id' => $volkswagenBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Palio', 'vehicle_brand_id' => $fiatBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Argo', 'vehicle_brand_id' => $fiatBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Sandero', 'vehicle_brand_id' => $renaultBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Clio', 'vehicle_brand_id' => $renaultBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Saveiro', 'vehicle_brand_id' => $volkswagenBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
                ['title' => 'Uno', 'vehicle_brand_id' => $fiatBrand->id, 'created_at' => $createdAt, 'updated_at' => $updatedAt],
            ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_models');
    }
};
