<?php

namespace App;
use App\Project;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'phone', 'position','comment', 'profile','english','salary','source','status'
    ];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }
}
