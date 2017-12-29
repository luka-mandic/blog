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

    public function storeLike(Post $post)
    {
    	$user_id = Auth()->user()->id;
    	$user = User::where('id', $user_id)->first();

    	//If the post hasn't been liked or disliked by the user
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
    		/* The updateExistingPivot method doesn't work, as it doesn't update the columns like and dislike
    		$user->likes()->updateExistingPivot($post, ['like' => true, 'dislike' => false]); */

			$user->likes()->detach($post);
			$user->likes()->attach($post, ['like' => true, 'dislike' => false]);
    		$post->decrement('dislikes_count');
    		$post->increment('likes_count');
    	}


    	return back();
    }

    public function storeDislike(Post $post)
    {
    	$user_id = Auth()->user()->id;
    	$user = User::where('id', $user_id)->first();
    	if(!$user->likes->contains($post->id))
    	{
    		$user->likes()->attach($post, ['like' => false, 'dislike' => true]);
    		$post->increment('dislikes_count');
    	}

    	elseif($user->likes->find($post)->pivot->dislike == 1)
    	{
    		$user->likes()->detach($post);
    		$post->decrement('dislikes_count');
    	}

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
