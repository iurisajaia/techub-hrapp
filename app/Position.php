<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position' , 'salary' , 'ph' ,'person_id'
    ];

    public function person()
    {
        return $this->belongsTo('App\Person');

    }
}
