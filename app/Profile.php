<?php

namespace App;
use App\Project;
use App\Technology;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'phone', 'position', 'profile','english','salary','source','status','author_id' ,'portfolio', 'comment' , 'net'
    ];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
    
    
}
