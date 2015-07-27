@extends('layouts.master')

@section('content')



<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('cliente/') }}"  target="_self"><span class"glyphicon glyphicon-star">Agregar Cliente</span></a>
    </button>
  </div>
</div>
</div>
<div class="row search">
      <div class="col-sm-3">
         <input type="text" id="buscar" class="form-control insearch"  placeholder="Nombre" style="
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
  <div class="col-xs-12"><h4 class="resum bg-primary">Info</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>Fecha creación</th>
        
        <th>Nombre</th>
        <th>Direccion</th>
        <th>N. cuenta</th>
        
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->created_at}}</td>
      
        <td>{{ $user->nombre}}</td>
        <td>{{ $user->direccion}}</td>
        <td>{{ $user->ncuenta}}</td>
        
        
        <td><a href="{{ URL::to('cliente/' . $user->id) }} " target="_self"><span class="label label-info">Actualizar</span></a>
            <a href="{{ URL::to('cliented/' . $user->id) }} " target="_self"><span class="label label-warning">Eliminar</span></a>
        </td>
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