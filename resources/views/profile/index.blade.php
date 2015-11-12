@extends('templates.default')

@section('content')

	<div class="row">
		<div class="col-md-5">
			@include('user.partials.userblock')
			<hr>
		</div>
		<div class="col-md-4 col-md-offset-3">

			@if (Auth::user()->hasFriendRequestPending($user))
				
				<p>Waiting for {{ $user->getNameorUsername() }} to accept your request.</p>

			@endif
			<h4>
				{{
					$user->getNameorUsername()
				}}'s friends.
			</h4>
			
			@if(!$user->friends()->count())
				<p>
					{{
						$user->getNameorUsername()
					}} has no friends.
				</p>

			@else

				@foreach ($user->friends() as $user)
					
					@include('user/partials/userblock')

				@endforeach
			@endif
		</div>
	</div>
@stop