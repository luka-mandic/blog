@extends('master')

@section('content')
  @if($posts)
    @foreach($posts as $post)
      <div class="blog-post">
      	<a href="/posts/{{ $post->id }}">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        </a>
        <p class="blog-post-meta">{{ $post->created_at->toFormattedDateString() }} by <a href="/?user={{ $post->user->id }}">
            {{ $post->user->name }}
          </a>
        <br>
        @if(count($post->tags))
          @foreach($post->tags as $tag)
            <a href="/posts/tags/{{ $tag->name }}">
            <span class="badge badge-pill badge-primary">{{ $tag->name }}</span>
            </a>
          @endforeach
        @endif

        </p>


        <p>{!! nl2br($post->body) !!}</p>
      </div><!-- /.blog-post -->
    @endforeach
  @endif
@endsection