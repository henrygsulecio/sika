@extends('layouts.master')

@section('content')


<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('ruta/') }}"><span class"glyphicon glyphicon-star">Agregar Ruta</span></a>
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
        <th>ID</th>
        <th>Fecha creación</th>
        
        <th>Ruta N.</th>
        <th>Nombre</th>
        <th>Direcci&oacute;n</th>
        
        
        <th>Cuenta</th>
        
        <th class="entrega" style="background:#dedede;">Estado</th>
       
        <th class="entrega" style="background:#dedede;">Ubicación entregado</th>
       
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->ruta_id}}</td>
       <td>{{ $user->created_at}}</td>
       
       <td>{{ $user->nrutas}}</td>
       <td>{{ $user->nombre}}</td>
       
       <td>{{ $user->direccion}}</td>
       
      
       
        <td>{{ $user->ncuenta}}</td>
        
        <td>{{ $user->estado}}</td>
        
        <td>{{ $user->checkP}}</td>
        
        
        <td><a href="{{ URL::to('infoDetalle/' . $user->ruta_id) }}" target="_blank"><span class="label label-info">Ver</span></a>
          <a href="{{ URL::to('ruta/' . $user->ruta_id) }}" target="_blank"><span class="label label-info">Actualizar</span></a>
            <a href="{{ URL::to('rutad/' . $user->ruta_id) }}"><span class="label label-warning">Eliminar</span></a>
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
<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportinfo') }} target="_self"><span class"glyphicon glyphicon-star">Descargar Todo.csv</span></a>
    </button>

     <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('rango') }} target="_self""><span class"glyphicon glyphicon-star">Descargar por repartidor.csv</span></a>
    </button>

    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('rangof') }} target="_self""><span class"glyphicon glyphicon-star">Descargar por fecha.csv</span></a>
    </button>
  </div>
</div>
</div>

@stop