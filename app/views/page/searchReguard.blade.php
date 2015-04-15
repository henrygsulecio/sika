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
            window.open("/searchReguards/"+value)
         }
     </script>
</div>

<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Reguards</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>Fecha</th>
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Tel&eacute;fono</th>
        <th>Telco</th>
        
        
        <th>Codigo</th>
        <th>Estado</th>
        <th>Cambiar estado</th>
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->updated_at}}</td>
       <td>{{ $user->lastname}}</td>
       <td>{{ $user->firstname}}</td>
       
       <td><a href="{{ URL::to('record/' . $user->phone) }}">{{ $user->phone}}</a></td>
       <td>{{ $user->telco}}</td>
      
       
        <td>{{ $user->codigo}}</td>
       <td>{{ $user->estado}}</td>
        
        <td><a href="{{ URL::to('reguardStatus/' . $user->id) }}"><span class="label label-info">Actualizar estado</span></a></td>
        <td><a href="{{ URL::to('user/' . $user->user_id) }}"><span class="label label-info">Actualizar</span></a></td>
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

<!--<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportinfo') }}"><span class"glyphicon glyphicon-star">Descargar .csv</span></a>
    </button>
  </div>
</div>-->

@stop