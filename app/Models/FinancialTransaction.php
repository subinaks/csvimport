<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;
    protected $fillable=['module_id','trans_id','admission_no','voucher_no','amount','transaction_date','cr_dr','entry_mode','branch_id','academic_year'];
   
}
