<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonFeeCollection extends Model
{
    use HasFactory;
    protected $fillable=["module_id","trans_id","admission_no","roll_no","amount","branch_id","academic_year","financial_year","recpt_no","entry_mode","inactive","paid_date"];

}
