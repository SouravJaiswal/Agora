@extends('templates.default')

@section('content')

	<div class="row">
		<div class="col-md-5">
			@include('user.partials.userblock')
			<hr>

			@if(!$statuses->count())
        		<p>There's nothing in your timeline, yet.</p>
        	@else
        		@foreach ($statuses as $status)
        			<div class="media">
    					<a class="pull-left" href="#">
        					<img class="media-object" alt="{{$status->user->getNameorUsername()}}" src="{{ $status->user->getAvatar()}}">
    					</a>
				    <div class="media-body">
        				<h4 class="media-heading"><a href="{{route('profile.index',['username'=>$status->user->username])}}">{{$status->user->getFirstNameorUsername()}}</a></h4>
        				<p>{{$status->body}}</p>
				        <ul class="list-inline">
				            <li>{{$status->created_at->diffForHumans()}}</li>
				           @if ($status->user->id !== Auth::user()->id  && !Auth::user()->hasLikedStatus($status))
                				<li><a href="{{route('status.like',['statusId'=>$status->id])}}">Like</a></li>
                			@endif
                				<li>{{$status->likes->count()}} {{str_plural('like',$status->likes->count())}}</li>
            				
				        </ul>

			        @foreach($status->replies as $reply)
	       				<div class="media">
    						<a class="pull-left" href="#">
        						<img class="media-object" alt="{{$reply->user->getNameorUsername()}}" src="{{ $reply->user->getAvatar()}}">
    					</a>
					    <div class="media-body">
        					<h4 class="media-heading"><a href="{{route('profile.index',['username'=>$reply->user->username])}}">{{$reply->user->getFirstNameorUsername()}}</a></h4>
        					<p>{{$reply->body}}</p>
					        <ul class="list-inline">
					            <li>{{$reply->created_at->diffForHumans()}}</li>
					            @if ($reply->user->id !== Auth::user()->id && !Auth::user()->hasLikedStatus($reply))
                					<li><a href="{{route('status.like',['statusId'=>$reply->id])}}">Like</a></li>
                				@endif
                					<li>{{$reply->likes->count()}} {{str_plural('like',$reply->likes->count())}}</li>
					            
						    </ul>
    					</div>
					    </div>
					@endforeach	
					@if ($authUserIsFriend || Auth::user()->id == $status->user_id)
				        <form role="form" action="{{route('status.reply',['status-id'=>$status->id])}}" method="post">
				            <div class="form-group {{  $errors->has("reply-{$status->id}") ? 'has-error' : '' }}">
				                <textarea name="reply-{{$status->id}}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
				            	@if($errors->has("reply-{$status->id}"))
									<span class="help-block">
										{{ $errors->first("reply-{$status->id}") }}
									</span>
							    @endif
				            </div>
				             <input type="hidden" name="_token" value="{{ Session::token() }}">
				            <input type="submit" value="Reply" class="btn btn-default btn-sm">
				        </form>
        			@endif
    			</div>
    		</div>
        	@endforeach
        	{!! $statuses->render() !!}
        @endif
		</div>
		<div class="col-md-4 col-md-offset-3">

			@if (Auth::user()->hasFriendRequestPending($user))
				
				<p>Waiting for {{ $user->getNameorUsername() }} to accept your request.</p>

			@elseif (Auth::user()->hasFriendRequestRecieved($user))

				<a href="{{ route('friend.accept',['username'=>$user->username]) }}" class="btn btn-primary">Accept Friend Request</a>

			@elseif (Auth::user()->isFriendsWith($user))

				<p>You and {{ $user->getNameorUsername() }} are friends.</p>

				<form action="{{route('friend.delete',['username'=>$user->username])}}" method="post">
					<input type="submit" value="Delete Friend" class="btn btn-primary"></input>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
				</form>

			@elseif(Auth::user()->id !== $user->id)

				<a href="{{ route('friend.add',['username' => $user->username]) }}" class="btn btn-primary">Add as friend.</a>

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