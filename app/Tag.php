<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany('\App\Post');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function prepareTags(string $tags)
    {
    	$created_tags = explode(",", $tags);

        $tags = array_map('trim', $created_tags);

        foreach($tags as $tag)
        {
            $new_tag = Tag::create([
                'name' => $tag,
            ]);
            $tagIDs[] = $new_tag->id;
            
        }

        return $tagIDs;

    }

    public static function updateTags(string $created_tags = null, array $selected_tags = null)
    {
    	if ($created_tags !== null && $selected_tags !== null)
        {
            $new_tags = Tag::prepareTags($created_tags);
            $tags = array_merge($new_tags, $selected_tags);

            return $tags;
            
        }

        elseif ($created_tags !== null && $selected_tags == null)
        {
            $new_tags = Tag::prepareTags($created_tags);

            return $new_tags;
        }

        elseif ($created_tags == null && $selected_tags !== null)
        {
            return $selected_tags;
        }

        else
        {
        	return;
        }
    }

}
