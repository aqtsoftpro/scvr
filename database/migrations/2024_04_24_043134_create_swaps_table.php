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
        Schema::create('swaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('swaps')->nullOnDelete();
            $table->foreignId('van_out_id')->nullable()->constrained('van_outs')->nullOnDelete();
            $table->string('condition')->nullable();
            $table->string('video')->nullable();
            $table->double('amount', 16, 2)->default(0.00);
            $table->double('rem_amount', 16, 2)->default(0.00);
            $table->enum('amount_status', ['partially_paid', 'fully_paid', 'unpaid', 'other'])->default('unpaid');
            $table->string('amount_tracking_id')->nullable();
            $table->string('vehicle_reg')->nullable();
            $table->string('out_date')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swaps');
    }
};
