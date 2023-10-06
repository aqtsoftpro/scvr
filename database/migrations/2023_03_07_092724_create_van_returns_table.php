<?php

use App\Location;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('van_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('vanout_id');
            $table->integer('mileage');
            $table->string('fuel_tank');
            $table->string('condition');
            //bolean
            $table->boolean('demage_caused_by_customer');
            $table->string('demage_picture')->nullable();
            $table->text('demage_text')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('vanout_id')->references('id')->on('van_outs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_returns');
    }
};
