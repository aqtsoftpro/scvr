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
        Schema::table('van_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->integer('mileage');
            $table->string('fuel_tank');
            $table->string('condition');
            //bolean
            $table->boolean('demage_caused_by_customer');
            $table->string('demage_picture');
            $table->text('demage_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('van_returns', function (Blueprint $table) {
            //
        });
    }
};
