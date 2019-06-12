<?php

namespace App;
use App\Profile;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = [
        'title' , 'author_id'
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }
}
