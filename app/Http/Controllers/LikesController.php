<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Post;
use \App\User;

class LikesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    // Handles the logic for likes
    public function storeLike(Post $post)
    {
    	$user_id = Auth()->user()->id;
    	$user = User::where('id', $user_id)->first();

    	//If the post hasn't been liked or disliked by the user increment like count, and add user->post relation
    	if(!$user->likes->contains($post->id))
    	{
    		$user->likes()->attach($post, ['like' => true, 'dislike' => false]);
    		$post->increment('likes_count');
    	}

    	//If the post has been liked then detach the record and decrement like count
    	elseif($user->likes->find($post)->pivot->like == 1)
    	{
    		$user->likes()->detach($post);
    		$post->decrement('likes_count');
    	}

    	//If the post has been disliked then update the like to true, dislike to false, and decrement dislike count, increment like count
    	else
    	{
    		/* The updateExistingPivot method doesn't work, as it doesn't update the columns like and dislike, so i had to use detach, attach
    		$user->likes()->updateExistingPivot($post, ['like' => true, 'dislike' => false]); */

			$user->likes()->detach($post);
			$user->likes()->attach($post, ['like' => true, 'dislike' => false]);
    		$post->decrement('dislikes_count');
    		$post->increment('likes_count');
    	}


    	return back();
    }

    // Handles the logic for dislikes
    public function storeDislike(Post $post)
    {
    	$user_id = Auth()->user()->id;
    	$user = User::where('id', $user_id)->first();

        // If the post hasn't been liked or disliked by the user increment dislike count, and add user->post relation
    	if(!$user->likes->contains($post->id))
    	{
    		$user->likes()->attach($post, ['like' => false, 'dislike' => true]);
    		$post->increment('dislikes_count');
    	}

        //If the post has been disliked then detach the record and decrement dislike count
    	elseif($user->likes->find($post)->pivot->dislike == 1)
    	{
    		$user->likes()->detach($post);
    		$post->decrement('dislikes_count');
    	}

        //If the post has been liked then update the dislike to true, like to false, and decrement like count, increment dislike count
    	else
    	{
    		$user->likes()->detach($post);
			$user->likes()->attach($post, ['like' => false, 'dislike' => true]);
    		$post->increment('dislikes_count');
    		$post->decrement('likes_count');
    	}


    	return back();
    }
}
