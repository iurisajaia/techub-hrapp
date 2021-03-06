<?php

namespace App;
use App\Profile;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title','author_id','start_date' , 'end_date' , 'referral' , 'status' , 'comment'  , 'order'
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }
}
