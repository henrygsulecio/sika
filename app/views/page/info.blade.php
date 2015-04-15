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
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('cliente/') }}"><span class"glyphicon glyphicon-star">Agregar Cliente</span></a>
    </button>
  </div>
</div>
</div>


<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Info</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>Fecha</th>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Direcci&oacute;n</th>
        
        
        <th>Cuenta</th>
        <th>Pedido</th>
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->created_at}}</td>
       <td>{{ $user->lastname}}</td>
       <td>{{ $user->firstname}}</td>
       
       <td><a href="{{ URL::to('record/' . $user->telefono) }}">{{ $user->telefono}}</a></td>
       
      
       
        <td>{{ $user->galones}}</td>
        <td>{{ $user->cubetas}}</td>
        <td>{{ ($user->galones*20) + ($user->cubetas*50)}}</td>
        
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
<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportinfo') }}"><span class"glyphicon glyphicon-star">Descargar .csv</span></a>
    </button>
  </div>
</div>
</div>

@stop