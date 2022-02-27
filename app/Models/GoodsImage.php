<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['goods_id', 'name', 'order'];
}
