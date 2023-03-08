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
        Schema::create('insurance', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->unsignedBigInteger('policy_type_id');
            $table->string('policy_start_date');
            $table->string('policy_end_date');
            $table->integer('road_side_assistance');
            $table->integer('road_side_assistance_start_date');
            $table->integer('road_side_assistance_end_date');
            $table->integer('demage_details');
            $table->timestamps();

            $table->foreign('policy_type_id')->references('id')->on('policy_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance');
    }
};
