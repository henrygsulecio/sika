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
        <th>Fecha creación</th>
        <th>Fecha actualización</th>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Direcci&oacute;n</th>
        
        
        <th>Cuenta</th>
        <th>Pedido</th>
        <th>Número Factura</th>
        <th>Número Orden</th>
        <th>Número sHR</th>
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->created_at}}</td>
       <td>{{ $user->updated_at}}</td>
       <td>{{ $user->ruta_id}}</td>
       <td>{{ $user->nombre}}</td>
       
       <td>{{ $user->direccion}}</td>
       
      
       
        <td>{{ $user->ncuenta}}</td>
        <td>{{ $user->pedido}}</td>
        <td>{{ $user->nfactura}}</td>
        <td>{{ $user->norden}}</td>
        <td>{{ $user->nhr}}</td>
        
        
        <td><a href="{{ URL::to('ruta/' . $user->ruta_id) }}"><span class="label label-info">Actualizar</span></a></td>
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