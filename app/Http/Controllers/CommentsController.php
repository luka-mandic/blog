<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Post;
use \App\Comment;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Post $post)
    {

    	$this->validate(request(),[
    		'body' => 'required|min:2',
    	]);

    	Comment::create([
    		'body' => request('body'),
    		'post_id' => $post->id,
    		'user_id' => auth()->user()->id,
    	]);

    	return back();
    }
}
