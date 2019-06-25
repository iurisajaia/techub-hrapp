<?php

namespace App;
use App\Profile;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment', 'author_id'
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
