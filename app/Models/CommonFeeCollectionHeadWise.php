<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonFeeCollectionHeadWise extends Model
{
    use HasFactory;
    protected $fillable=['module_id','receipt_id','head_id','head_name','branch_id','amount'];
}
