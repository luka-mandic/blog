<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
	protected $fillable = ['title', 'body', 'user_id'];
	
    public function user()
    {
    	return $this->belongsTo('\App\User');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment');
    }


    public function scopeFilter($query, $filters)
    {
        if(isset($filters['month'])) {
            $month = $filters['month'];
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if(isset($filters['year'])) {
            $year = $filters['year'];
            $query->whereYear('created_at', $year);
        }

        if(isset($filters['user'])) {
            $id = $filters['user'];
            $query->where('user_id', $id);
        }
    }

    public static function archives()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Tag');
    }

    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    
}
