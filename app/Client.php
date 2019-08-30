<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Persons;
class Client extends Model
{
    protected $fillable = [
        'name' , 'contact_person' , 'number' , 'start_date', 'end_date'
    ];

   
    public function clientpersons(){
        return $this->hasMany('App\ClientPerson');
    }

    public function persons(){
        return $this->belongsToMany('App\Person');
    }
    

}
