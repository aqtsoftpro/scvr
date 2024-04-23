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
            $table->boolean('long_term')->default(false);
            $table->string('due_return')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('van_outs', function (Blueprint $table) {
            //
        });
    }
};
