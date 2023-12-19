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
        Schema::create('financial_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('financial_transaction_id');
            $table->integer('module_id');
            $table->double('head_id');
            $table->integer('branch_id');
            $table->string('head_name');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transaction_details');
    }
};
