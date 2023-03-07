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
        Schema::table('tax_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tax_type_id');
            $table->integer('amount');
            $table->string('date');
            $table->string('filer_name');
            $table->string('filer_contact');
            $table->integer('account_fee');
            $table->text('comments');
            $table->timestamps();

            $table->foreign('tax_type_id')->references('id')->on('tax_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_records', function (Blueprint $table) {
            //
        });
    }
};
