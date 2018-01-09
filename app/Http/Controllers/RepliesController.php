<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
   

    public function store(Request $request)
    {
        //dd($request->input('comment_id'));

        Reply::create([
            'body' => request('body'),
            'comment_id' => request('comment_id'),
            'user_id' => auth()->user()->id,
        ]);

        return back();
    }

   
}
