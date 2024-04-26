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
        Schema::table('swaps', function (Blueprint $table) {
            $table->boolean('long_term')->default(true);
            $table->boolean('status')->default(true);
            $table->dateTime('due_return')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->integer('rental_period')->nullable();
            $table->double('rental_amount', 16, 2)->default(0.00);
            $table->double('mileage')->nullable();
            $table->integer('amount_frequency')->nullable();
            $table->double('bond_deposit', 16, 2)->nullable();
            $table->string('payment_mode')->nullable();
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
