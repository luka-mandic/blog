@extends('master')

@section('title', $post->title.' - ')


@section('content')
	<h1>{{ $post->title }}  

    @auth
		@if(Auth::user()->id == $post->user_id)
          <a href="{{ action('PostsController@destroy', $post->id) }}" class="btn btn-danger btn-sm float-right mt-3" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete</a>
          <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning btn-sm float-right mr-1 mt-3">Edit</a>
          
        @endif
    @endauth

	</h1>


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

	{!! nl2br($post->body) !!}

	<hr>

	<form id="delete-form" action="{{ action('PostsController@destroy', $post->id) }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>

	@auth
		<form method="post">
			<div class="form-group">
				<textarea name="body" class="form-control" id="commentTxt" placeholder="Add a comment..." required></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary submitComment" onclick="event.preventDefault();">Comment</button>
			</div>
		</form>
	@endauth
	
	@foreach($post->comments as $comment)
		<div class="card">
		  <div class="card-header">
		    <strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span> <a href="#" onclick="event.preventDefault();" class="float-right replyLink" data-id="{{ $comment->id }}">Reply</a>
		  </div>
		  <div class="card-body">
		    <p class="card-text">{{ $comment->body }}</p>
		  </div>
		</div>



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
		<div id="replyForm{{$comment->id }}"">
			
		</div>
		<br>
	@endforeach


	
@section('scripts')	
	<script type="text/javascript">

		$("button.submitComment").click(function(event){
			var comment = $("textarea#commentTxt").val();
			var post_id = {{ $post->id }};
			$.ajax({
				url: "https://blog.dev/posts/{{ $post->id }}/comments",
				method: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {body: comment, post_id: post_id},
				 
			}).done(function(){
				location.reload();
			});
		});


		$("a.replyLink").click(function(){
			var id = $(this).data("id");

			var form = $("div#replyForm"+id);

			
			$(form).html('<form class="ml-5">' +
				'<div class="form-group">' +
					'<textarea name="body" class="form-control" id="'+id+'" placeholder="Add a comment..."></textarea>' +
				'</div>' +
				'<div class="form-group">' +
					'<button type="submit" class="btn btn-primary btn-sm submitReply" onclick="event.preventDefault();">Comment </button>' +
					' <button class="btn btn-danger btn-sm cancelButton" onclick="event.preventDefault();">Cancel</button>' +
				'</div>'+
				
			'</form>');

			
		
			$("button.cancelButton").click(function(event){
				$(event.target).closest("form").hide();
			});

			$("button.submitReply").click(function(event){
				var reply = $("textarea#"+id).val();

				$.ajax({
					url: "https://blog.dev/posts/{{ $post->id }}/replies",
					method: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {body: reply, comment_id: id},
					 
				}).done(function(){
					location.reload();
				});

			});
		
		});

		
	</script>

@endsection

@endsection