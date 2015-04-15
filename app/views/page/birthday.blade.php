@extends('layouts.master')

@section('content')
<div class="row search">
      <div class="col-sm-3">
         <input type="text" id="buscar" class="form-control insearch"  placeholder="Buscar numero o codigo" style="
    height: 33px;">
      </div>
     <button type="submit" class="btn btn-primary" onclick="trackChange(document.getElementById('buscar').value)">Buscar</button>
     <script>
         function trackChange(value)
         {
            window.open("search/"+value)
         }
     </script>
</div>

<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Cumpeañeros del presente mes</h4></div>
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
        <th>Birthday</th>
        <th>Acciones</th
      </tr>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <!--<td><a href="{{ URL::to('user/' . $user->id) }}">{{ $user->phone }}</a></td>-->
        <td><a href="{{ URL::to('record/' . $user->phone ) }}">{{ $user->phone }}</a></td>
        <td>{{ $user->telco }}</td>
        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
        <td>{{ $user->messages }}</td>
        
        <td>{{ $user->birthday }}</td>
        <td><a href="{{ URL::to('user/' . $user->id) }}"><span class="label label-info">Actualizar</span></a></td>
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

<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportBirthday') }}"><span class"glyphicon glyphicon-star">Descargar .csv</span></a>
    </button>
  </div>
</div>
</div>

</div>

@stop