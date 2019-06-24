<?php

namespace App;
use  App\Profile;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'comment','profile_id'
    ];

    public function comments(){
        return $this->belongsTo(Profile::class);
    }
}
