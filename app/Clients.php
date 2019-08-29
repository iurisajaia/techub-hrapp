<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persons;
class Clients extends Model
{
    protected $fillable = [
        'name' , 'contact_person' , 'number' , 'start_date', 'end_date'
    ];

    public function persons(){
        return $this->belongsToMany(Persons::class ,'client_person' , 'person_id' ,'client_id');
    }
}
