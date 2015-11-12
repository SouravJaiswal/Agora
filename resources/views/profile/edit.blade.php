@extends('templates.default')

@section('content')

<h3>Edit Profile</h3>

<form class="form-horizontal" method="post" action="{{route('profile.edit')}}"> 
<div class="row">
<div class="col-md-6">
  <div class="form-group{{  $errors->has('first_name') ? 'has-error' : '' }}">
    <label for="first_name" class="col-sm-4 control-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="first_name" name="first_name" value="{{Request::old('first_name') ?: Auth::user()->first_name}}">
      @if($errors->has('first_name'))
		<span class="help-block">
			{{ $errors->first('first_name') }}
		</span>
    @endif
    </div>
  </div>
  <div class="form-group {{  $errors->has('last_name') ? 'has-error' : '' }}">
    <label for="last_name" class="col-sm-4 control-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="last_name" name="last_name" 
      value="{{Request::old('last_name') ?: Auth::user()->last_name}}">
      @if($errors->has('last_name'))
		<span class="help-block">
			{{ $errors->first('last_name') }}
		</span>
    @endif
    </div>
  </div>
  <div class="form-group {{  $errors->has('location') ? 'has-error' : '' }}">
    <label for="location" class="col-sm-4 control-label">Location</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="location" name="location"
      value="{{Request::old('location') ?: Auth::user()->location}}">
      @if($errors->has('location'))
		<span class="help-block">
			{{ $errors->first('location') }}
		</span>
    @endif
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Update</button>
    </div>
  </div>
  <input type="hidden" name="_token" value="{{ Session::token() }}">
  </div>
  </div>
</form>

@stop