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
            $table->double('bond_diff')->default(0.00);
            $table->double('cust_fine')->default(0.00);
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
