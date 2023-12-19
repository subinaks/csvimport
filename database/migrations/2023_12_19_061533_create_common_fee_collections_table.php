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
        Schema::create('common_fee_collections', function (Blueprint $table) {
            $table->id();
            $table->double('module_id');
            $table->double('trans_id');
            $table->string('admission_no');
            $table->string('roll_no');
            $table->double('amount');
            $table->integer('branch_id');
            $table->string('academic_year');
            $table->string('financial_year');
            $table->string('recpt_no');
            $table->integer('entry_mode');
            $table->integer('inactive');
            $table->date('paid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_fee_collections');
    }
};
