<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ClientPerson;

class Month extends Model
{
    protected $fillable = [
        'name' 
    ];

    public function clientpersons(){
        return $this->hasMany(ClientPerson::class);
    }

}
