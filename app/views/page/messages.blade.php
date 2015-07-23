@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Mensajes</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>ID</th>
        <th>Phone</th>
        <th>Telco</th>
        <th>Message</th>
        <th>Name</th>
        <th>In/Out</th>
        <th>Date</th>
      </tr>
      @foreach ($messages as $message)
      <tr>
        <td>{{ $message->id }}</td>
        <td><a href="{{ URL::to('user/' . $message->user_id) }}">{{ $message->phone }}</a></td>
        <td>{{ $message->telco }}</td>
        <td>{{ $message->msg }}</td>
        <td>{{ $message->firstname }}</td>
        <td>{{ ($message->msg_out) ? 'out' : 'in' }}</td>
        <td>{{ $message->created_at }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    {{ $messages->links() }}
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportMessage') }}" target="_self"><span class"glyphicon glyphicon-star">Descargar .csv</span></a>
    </button>
  </div>
</div>

@stop