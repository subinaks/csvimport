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
        Schema::create('common_fee_collection_head_wises', function (Blueprint $table) {
            $table->id();
            $table->double('module_id');
            $table->double('receipt_id');
            $table->double('head_id');
            $table->string('head_name');
            $table->integer('branch_id');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_fee_collection_head_wises');
    }
};
