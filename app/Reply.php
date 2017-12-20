<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body', 'user_id', 'comment_id'];

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }

    public function comment()
    {
    	return $this->belongsTo('\App\Comment');
    }
}
