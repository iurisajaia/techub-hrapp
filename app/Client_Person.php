<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persons;
use App\Clients;

class Client_Person extends Model
{
    protected $table = 'client_person';

    protected $fillable = [
        'type' , 'salary', 'sum'
    ];

    public function persons(){
        return $this->hasMany(Persons::class);
    }
    public function clients(){
        return $this->hasMany(Clients::class);
    }
}
