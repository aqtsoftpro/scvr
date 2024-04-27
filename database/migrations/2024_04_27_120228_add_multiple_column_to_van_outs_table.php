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
            $table->string('vehicle_return_date')->nullable();
        });

        Schema::table('swaps', function (Blueprint $table) {
            $table->string('vehicle_return_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('swaps', function (Blueprint $table) {
            //
        });
    }
};
