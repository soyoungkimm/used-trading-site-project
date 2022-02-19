<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Alarm extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //protected $connection = 'junggo'; 
    protected $table = 'alarm'; 
    public $timestamps = false;
    protected $fillable = [
        'content',
        'writeday',
        'goods_id',
        'user_id'
    ];
}
