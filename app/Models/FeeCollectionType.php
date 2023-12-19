<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCollectionType extends Model
{
    use HasFactory;
    protected $fillable=['branch_id','collection_head','collection_description'];
}
