<div class="media">
  <div class="media-left">
    <a href="#">
      <img class="media-object" src="https://placehold.it/32x32" alt="{{ $user->getNameOrUserName() }}">
    </a>
  </div>
  <div class="media-body">
    <h4 class="media-heading">{{ $user->getNameOrUserName() }}</h4>

	@if($user->location)

		<p>{{$user->location}}</p>

	@endif
  </div>
</div>