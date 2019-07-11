<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    protected $fillable = [
       'title' , 'path','author_id'
    ];
}
