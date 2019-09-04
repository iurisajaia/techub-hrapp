<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPerson extends Model
{
    protected $table ='client_person';

    protected $fillable = [
        'person_id' , 'client_id' , 'month_id' , 'type' , 'cost' , 'rate' , 'total' , 'salary', 'profit', 'percent' ,'hours'
    ];

    
    public function month(){
        return $this->belongsTo('App\Month');
    }
    public function person(){
        return $this->belongsTo('App\Person');
    }
    public function client(){
        return $this->belongsTo('App\Client');
    }


}
