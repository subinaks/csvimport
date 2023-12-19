<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransactionDetail extends Model
{
    use HasFactory;
    protected $fillable=['financial_transaction_id','module_id','head_id','branch_id','head_name','amount'];

}
