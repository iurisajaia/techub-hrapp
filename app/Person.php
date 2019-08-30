<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table ='person';
    
    protected $fillable = [
        'name' , 'c_date'
    ];

    public function positions(){
        return $this->hasMany('App\Position');
    }

    public function clientpersons(){
        return $this->hasMany('App\ClientPerson');
    }

    public function clients(){
        return $this->belongsToMany('App\Client');
    }

}
