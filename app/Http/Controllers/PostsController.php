<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;


class PostsController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->filter(request(['month', 'year', 'user']))->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('name', 'asc')->pluck('name', 'id')->all();
        
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = Post::create([
            'title' => request('title'), 
            'body' => request('body'),
            'user_id' => auth()->user()->id,
        ]);

        if($request->input('created_tags') !== null)
        {
            $created_tags = Tag::prepareTags($request->input('created_tags'));
            $post->tags()->attach($created_tags);
        }
        
        $post->tags()->attach($request->input('tags'));
        
        
        flash('Post has been created')->success();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        if($post->user_id == auth()->user()->id)
        {
            $tags = Tag::orderBy('name', 'asc')->pluck('name', 'id')->all();

            return view('posts.edit', compact('post', 'tags'));
        }

        else
        {
            flash('You do not have permission to view this page')->warning();

            return redirect('/');
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        if($post->user_id == auth()->user()->id)
        {
            $request->validate([
                'title' => 'required|max:255',
                'body' => 'required',
            ]);

            $post->update([
                'title' => request('title'), 
                'body' => request('body'),
            ]);

            $tags = Tag::updateTags($request->input('created_tags'), $request->input('tags'));
            $post->tags()->sync($tags);

            
            flash('Post updated')->success();
            return redirect()->action('PostsController@show', ['id' => $post]);
        }

        else
        {
            flash('You do not have permission to view this page')->warning();

            return redirect('/');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        flash('Post deleted')->danger();
        return redirect('/');
    }
}
