@extends('master')

@section('content')
	<h1>Edit post</h1>
	<hr>
	<form action="{{ action('PostsController@update', $post->id)}}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" name="title" value="{{ $post->title }}"  class="form-control" autofocus>
	</div>

	<div class="form-group">
		<label for="body">Body</label>
		<textarea name="body"  class="form-control" rows="15">{{ $post->body }}</textarea>
	</div>

	<div class="form-group">
		<label for="tagList">Tags</label>
		<select class="custom-select form-control" multiple="multiple" name="tags[]" data-toggle="tooltip" data-placement="top" title="Hold CTRL and click to select multiple tags">
			@foreach($tags as $key => $value)
				<option value="{{ $key }}" 
					@foreach($post->tagList as $tagID)
		 				
		 				@if($key == $tagID)
		 					selected="selected"
		 				@endif
		 				
		 			@endforeach
	 			>{{ $value }}</option>
			@endforeach
		</select>

	<div class="form-group">
		<input type="text" name="created_tags" placeholder="Add your own tags separated by commas"  class="form-control">
	</div>

	<div class="form-group">
		<input type="submit" value="Update" class="btn btn-primary">
	</div>	
	</form>

@endsection