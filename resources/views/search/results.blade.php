@extends('templates.default')

@section('content')

<h3>Search for {{ Request::input('query') }}</h3>

@if(!$users->count())

	<p>No search results found :(.</p>

@else
<div class="row">

	<div class="col-md-12">

		@foreach ($users as $user)

			@include('user/partials/userblock')	

		@endforeach

	</div>
	
</div>

@endif

@stop