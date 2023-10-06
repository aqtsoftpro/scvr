<?php

use App\VehicleType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('picture');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('model');
            $table->string('make');
            $table->string('vin');
            $table->integer('mileage');
            $table->string('purchase_date');
            $table->string('purchase_price');
            $table->string('seller_name');
            $table->string('seller_address');
            $table->integer('seller_contact_number');
            $table->timestamps();

            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
