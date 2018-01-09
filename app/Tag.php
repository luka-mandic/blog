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

    // Prepare the tags for storing into the database
    // First separate the users input by comma
    // then remove all whitespaces
    // create an array of the newly created tag ids
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

    // Update the tags of an existing post
    public static function updateTags(string $created_tags = null, array $selected_tags = null)
    {
        // If there are new tags created and selected from the list, then prepare the new tags and merge the two arays into one
    	if ($created_tags !== null && $selected_tags !== null)
        {
            $new_tags = Tag::prepareTags($created_tags);
            $tags = array_merge($new_tags, $selected_tags);

            return $tags;
            
        }

        // If the user only created new tags then prepare them and return them
        elseif ($created_tags !== null && $selected_tags == null)
        {
            $new_tags = Tag::prepareTags($created_tags);

            return $new_tags;
        }

        // If the user didn't create any new tags, only selected new ones
        elseif ($created_tags == null && $selected_tags !== null)
        {
            return $selected_tags;
        }

        // The user didn't change any tags
        else
        {
        	return;
        }
    }

}
