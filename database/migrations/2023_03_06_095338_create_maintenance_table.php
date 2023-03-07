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
        Schema::table('maintenance', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->integer('mileage');
            $table->varchar('date');
            $table->integer('service_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropifexist('maintenance');
    }
};
