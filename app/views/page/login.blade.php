@extends('layouts.master')

@section('css-site')
{{ HTML::style('css/' . $page . '.css') }}
@overwrite

@section('content')
<div class="row">
  <div class="col-md-6 col-md-push-3">
    <div class="text-center"><img src="{{ asset('imgs/logo.jpg') }}" width="323" height="100" alt="GuateVisi&oacute;n"></div>

    <form class="form-signin" role="form" action="{{ URL::route('dologin') }}" method="post">
      <h2 class="form-signin-heading">Validaci&oacute;n</h2>
      <div class="form-group">
        <input id="user" type="text" class="form-control" name="user" placeholder="User" required autofocus>
      </div>
      <div class="form-group">
        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
    </form>
  </div>
</div>
@stop