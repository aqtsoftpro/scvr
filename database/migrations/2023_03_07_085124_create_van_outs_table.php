<?php

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
        Schema::table('van_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('location_id');
            $table->string('reason_of_renting');
            $table->unsignedBigInteger('swap_with');
            $table->integer('rental_priod');
            $table->integer('rental_amount');
            $table->integer('mileage');
            $table->unsignedBigInteger('accessory_id');
            $table->string('due_return');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('accessory_id')->references('id')->on('accessories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('van_outs', function (Blueprint $table) {
            //
        });
    }
};
