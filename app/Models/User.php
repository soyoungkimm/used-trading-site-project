<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //protected $connection = 'junggo'; 
    protected $table = 'users'; 
    public $timestamps = false;

    public function getAuthPassword()
    {
        //dd("$this->pwd");
        return $this->pwd;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rank',
        'uid',
        'pwd',
        'name',
        'birth',
        'tel',
        'store_name',
        'open_date',
        'store_visit',
        'sale_num',
        'delivery_num',
        'image',
        'follower',
        'following',
        'good_num',
        'introduction'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
