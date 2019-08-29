<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Clients;
class Persons extends Model
{
    protected $table ='persons';
    
    protected $fillable = [
        'name' , 'position' , 'salary' , 'ph', 'c_date'
    ];

    public function clients(){
        return $this->belongsToMany(Clients::class , 'client_person' , 'client_id' ,'person_id');
    }
}
