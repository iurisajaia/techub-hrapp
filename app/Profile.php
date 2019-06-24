<?php

namespace App;
use App\Project;
use App\Technology;
use App\Comment;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'phone', 'position','comment', 'profile','english','salary','source','status','author_id'
    ];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
    
    public function comments(){
        return $this->belongsToMany(Comment::class);
    }
}
