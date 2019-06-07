<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'phone', 'position','comment', 'profile','english','salary','source','status'
    ];
}
