<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'review_id', 'content', 'writeday'];
}
