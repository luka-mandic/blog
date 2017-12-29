@extends('master')

@section('content')

  @if($posts)
    @foreach($posts as $post)
      <div class="blog-post">
      	<a href="/posts/{{ $post->id }}">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        </a>
        <div class="blog-post-meta">{{ $post->created_at->toFormattedDateString() }} by <a href="/?user={{ $post->user->id }}">
            {{ $post->user->name }}
          </a>
          <form action="/posts/{{ $post->id }}/dislike" method="post" class="float-right">
            <button type="submit" onclick="event.preventDefault()" class="dislikeBtn btn btn-link pr-2 ml-2" data-id="{{ $post->id }}" data-toggle="tooltip" data-placement="top" title="I dislike this"><i class="fa fa-thumbs-o-down"></i></button>{{ $post->dislikes_count }}
            {{ csrf_field() }}
          </form>

        <form action="/posts/{{ $post->id }}/like" method="post" class="float-right">
          <button type="submit" onclick="event.preventDefault()" class="likeBtn btn btn-link pr-2" data-id="{{ $post->id }}" data-toggle="tooltip" data-placement="top" title="I like this"><i class="fa fa-thumbs-o-up"></i></button>{{ $post->likes_count }}
          {{ csrf_field() }}
        </form>
        </div>
        @if(count($post->tags))
          @foreach($post->tags as $tag)
            <a href="/posts/tags/{{ $tag->name }}">
            <span class="badge badge-pill badge-primary">{{ $tag->name }}</span>
            </a>
          @endforeach
        @endif
        <hr>
        


        <p>{!! str_limit(nl2br($post->body), 800) !!}</p>
      </div><!-- /.blog-post -->
    @endforeach
  @endif


{{ $posts->appends(Request::except('page'))->links("vendor.pagination.bootstrap-4") }}

@endsection