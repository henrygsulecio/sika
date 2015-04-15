@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Usuarios</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>ID</th>
        <th>Phone</th>
        <th>Telco</th>
        <th>Name</th>
        <th>Messages</th>
        <th>Disable</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td><a href="{{ URL::to('user/' . $user->id) }}">{{ $user->phone }}</a></td>
        <td>{{ $user->telco }}</td>
        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
        <td>{{ $user->messages }}</td>
        <td>{{ ($user->disabled) ? 'true' : 'false' }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->updated_at }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    {{ $users->links() }}
  </div>
</div>
@stop