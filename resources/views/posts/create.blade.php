@extends('master')

@section('content')
	<h1>Create a post</h1>
	<hr>
	<form action="{{ action('PostsController@store') }}" method="POST">
	{{ csrf_field() }}

	<div class="form-group">
		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="{{ old('title') }}"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autofocus>

		@if ($errors->has('title'))
		    <span class="invalid-feedback">
		        <strong>{{ $errors->first('title') }}</strong>
		    </span>
		@endif
	</div>

	<div class="form-group">
		<label for="body">Body:</label>
		<textarea name="body"  class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" rows="15"></textarea>

		@if ($errors->has('body'))
		    <span class="invalid-feedback">
		        <strong>{{ $errors->first('body') }}</strong>
		    </span>
		@endif
	</div>

	<div class="form-group">
		<label for="tags">Tags:</label>
		<select class="custom-select form-control" multiple="multiple" name="tags[]" data-toggle="tooltip" data-placement="top" title="Hold CTRL and click to select multiple tags">
			@foreach($tags as $key => $value)
	 			<option value="{{ $key }}">{{ $value }}</option>
			@endforeach
		</select>
	</div>

	 <div class="form-group">
		<input type="text" name="created_tags" placeholder="Add your own tags separated by commas"  class="form-control{{ $errors->has('created_tags') ? ' is-invalid' : '' }}">

		@if ($errors->has('created_tags'))
		    <span class="invalid-feedback">
		        <strong>Tag or tags already exist!</strong>
		    </span>
		@endif
	</div>


	<div class="form-group">
		<input type="submit" value="Submit" class="btn btn-primary">
	</div>	
	</form>

@endsection