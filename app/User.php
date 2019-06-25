<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens , Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function isLogged(){
        return $this->role === 'admin' || $this->role === 'manager' || $this->role === 'viewer';
    }
    public function isManager(){
        return  $this->role === 'manager';
    }
    public function isManagerOrisAdmin(){
        return  $this->role === 'manager' || $this->role === 'admin';
    }

    // public $timestamps = false;

}
