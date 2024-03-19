<?php

use App\Accessory;
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
        Schema::create('van_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->string('reason_of_renting');
            $table->foreignId('swap_with')->constrained('vehicles')->cascadeOnDelete();
            $table->integer('rental_priod');
            $table->integer('rental_amount');
            $table->foreignId('accessory_id')->constrained()->cascadeOnDelete();
            $table->integer('mileage');
            $table->string('due_return');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_outs');
    }
};
