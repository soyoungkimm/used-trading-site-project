<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Good extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['title', 'image', 'category_id', 'category_de_id', 'category_de_de_id', 'area', 
    'state', 'exchange', 'price', 'delivery_fee', 'content', 'number', 'heart', 'view', 'writeday', 'user_id', 'sale_state'];
}
