@extends('templates.default')

@section('content')

<div class="row">
	<div class="col-md-6">
		<h3>Your Friends</h3>
		@if(!$users->count())
				<p>
					You have no friends.
				</p>

			@else

				@foreach ($users as $user)
					
					@include('user/partials/userblock')

				@endforeach
			@endif
	</div>
	<div class="col-md-6">
		<h4>Friend's Request</h4>
		@if(!$friends->count())
				<p>
					You have no friend requests.
				</p>

			@else

				@foreach ($friends as $user)
					
					@include('user/partials/userblock')

				@endforeach
			@endif
	</div>
</div>

@stop