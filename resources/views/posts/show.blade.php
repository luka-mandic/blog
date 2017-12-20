@extends('master')

@section('content')
	<h1>{{ $post->title }}</h1>
	<p class="blog-post-meta">{{ $post->created_at->toFormattedDateString() }} by <a href="/?user={{ $post->user->id }}">
            {{ $post->user->name }}
          </a> 
        @auth
			@if(Auth::user()->id == $post->user_id)
	          <a href="{{ action('PostsController@destroy', $post->id) }}" class="btn btn-danger btn-sm  float-right " onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete</a>
	          <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning btn-sm float-right mr-1">Edit</a>
	          
	        @endif
        @endauth
     <br>
        @if(count($post->tags))
          @foreach($post->tags as $tag)
          	<a href="/posts/tags/{{ $tag->name }}">
            <span class="badge badge-pill badge-primary">{{ $tag->name }}</span>
            </a>
          @endforeach
        @endif

      </p>
	<hr>

	{!! nl2br($post->body) !!}

	<hr>

	<form id="delete-form" action="{{ action('PostsController@destroy', $post->id) }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>

	@auth
		<form method="post" action="/posts/{{ $post->id }}/comments">
			{{ csrf_field() }}
			<div class="form-group">
				<textarea name="body" class="form-control" placeholder="Add a comment..." required></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Comment</button>
			</div>
		</form>
	@endauth
	
	@foreach($post->comments as $comment)
		<div class="card">
		  <div class="card-header">
		    <strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span> <a href="#" onclick="event.preventDefault(); showForm()" class="float-right">Reply</a>
		  </div>
		  <div class="card-body">
		    <p class="card-text">{{ $comment->body }}</p>
		  </div>
		</div>

//HVATA COMMENT ID OD SAMOG PRVOG POSTA U FORMU

		@foreach($comment->reply as $reply)
		<div class="card ml-5">
		  <div class="card-header">
		    <strong>{{ $reply->user->name }}</strong> <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span>
		  </div>
		  <div class="card-body">
		    <p class="card-text">{{ $reply->body }}</p>
		  </div>
		</div>
		@endforeach
		<br>
		<div id="replyForm" style="display: none">
			<form class="ml-5" method="post" action="/posts/{{ $post->id }}/replies">
				{{ csrf_field() }}
				<input type="hidden" name="comment_id" value="{{ $comment->id }}">
				<div class="form-group">
					<textarea name="body" class="form-control" placeholder="Add a comment..." required></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-sm">Comment</button> <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); hideForm()">Cancel</button>
				</div>
				
			</form>
		</div>
		<br>
	@endforeach


	
@section('scripts')	
	<script type="text/javascript">
		var form = document.getElementById("replyForm");

		function showForm()
		{
    		form.style.display = "block";
		}

		function hideForm()
		{
    		form.style.display = "none";
		}

	</script>

@endsection

@endsection