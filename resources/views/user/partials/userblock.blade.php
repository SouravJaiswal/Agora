<div class="media">
  <div class="media-left">
    <a href="{{  route('profile.index',['username' => $user->username])  }}">
      <img class="media-object" src="{{ $user->getAvatar() }}" alt="{{ $user->getNameOrUserName() }}">
    </a>
  </div>
  <div class="media-body">
    <a href="{{  route('profile.index',['username' => $user->username])  }}"><h4 class="media-heading">{{ $user->getNameOrUserName() }}</h4></a>

	@if($user->location)

		<p>{{$user->location}}</p>

	@endif
  </div>
</div>