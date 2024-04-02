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
        Schema::create('demage_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('van_out_id')->nullable()->constrained('van_outs')->nullOnDelete();
            $table->foreignId('van_return_id')->nullable()->constrained('van_returns')->nullOnDelete();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('van_outs', function (Blueprint $table) {
            $table->string('video')->nullable();
        });

        Schema::table('van_returns', function (Blueprint $table) {
            $table->string('video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demage_galleries');
    }
};
