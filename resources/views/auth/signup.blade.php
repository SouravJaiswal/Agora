@extends('templates.default')

@section('content')
<h3>Sign Up</h3>
<div class="row">

	<div class="col-md-6">
		<form class="form-horizontal" action="{{ route('auth.signup') }}" method="post">
  <div class="form-group {{  $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ Request::old('email') ?: ''}}">
       @if($errors->has('email'))
		<span class="help-block">
			{{ $errors->first('email') }}
		</span>
    @endif
    </div>
   
  </div>
  <div class="form-group {{  $errors->has('username') ? 'has-error' : '' }}">
    <label for="username" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
      <input type="input" class="form-control" name="username" id="username" placeholder="Username" value="{{ Request::old('username') ?: ''}}">
      @if($errors->has('username'))
		<span class="help-block">
			{{ $errors->first('username') }}
		</span>
    @endif
    </div>
  </div>
  <div class="form-group {{  $errors->has('password') ? 'has-error' : '' }}">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password" >
      @if($errors->has('password'))
		<span class="help-block">
			{{ $errors->first('password') }}
		</span>
    @endif
    </div>
    
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign Up</button>
    </div>
  </div>
  <input type="hidden" name="_token" value="{{ Session::token() }}">
</form>
	</div>
</div>

@stop