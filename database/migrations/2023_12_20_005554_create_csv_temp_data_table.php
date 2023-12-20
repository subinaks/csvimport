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
        Schema::create('csv_temp_data', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('accademic_year');
            $table->string('session');
            $table->string('alloted_category');
            $table->string('voucher_type');
            $table->string('voucher_no');
            $table->string('roll_no');
            $table->string('admission_no');
            $table->string('status');
            $table->string('fee_category');
            $table->string('faculty');
            $table->string('program');
            $table->string('department');
            $table->string('batch');
            $table->string('recept');
            $table->string('fee_head');
            $table->double('due_amount');
            $table->double('paid_amount');
            $table->double('consession_amount');
            $table->double('scholorship_amount');
            $table->double('reverse_amount');
            $table->double('write_amount');
            $table->double('adjust_amount');
            $table->double('refund_amount');
            $table->double('fund_amount');
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_temp_data');
    }
};
