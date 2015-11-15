@extends('templates.default')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <form role="form" action="{{ route('status.post') }}" method="post">
            <div class="form-group {{  $errors->has('status') ? 'has-error' : '' }}">
                <textarea placeholder="What's up {{ Auth::user()->getFirstNameorUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                @if($errors->has('status'))
					<span class="help-block">
						{{ $errors->first('status') }}
					</span>
			    @endif
            </div>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" class="btn btn-default">Update status</button>
        </form>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
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
            @if (($status->user->id !== Auth::user()->id) and !Auth::user()->hasLikedStatus($status))
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
            @if ($reply->user->id !== Auth::user()->id && !Auth::user()->hasLikedStatus($reply) )
                <li><a href="{{route('status.like',['statusId'=>$reply->id])}}">Like</a></li>
            @endif  
                <li>{{$reply->likes->count()}} {{str_plural('like',$reply->likes->count())}}</li>

            
    </ul>
    </div>
    </div>
		@endforeach	
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
    </div>
</div>
        	@endforeach
        	{!! $statuses->render() !!}
        @endif
    </div>
</div>

@stop