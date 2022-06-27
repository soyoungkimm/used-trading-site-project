<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    use HasFactory;
    //public $timestamps = false;
    protected $fillable = ['merchant_uid', 'imp_uid', 'amount', 'status', 'buy_user_id', 'sale_user_id', 'goods_id'];
}
