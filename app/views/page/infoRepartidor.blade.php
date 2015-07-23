@extends('layouts.master')

@section('content')


<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('repartidor/') }}" target="_self"><span class"glyphicon glyphicon-star">Agregar Repartidor</span></a>
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
        
        <th>Nombre</th>
        <th>Apellido</th>
        <th>N. Ruta</th>
        
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->created_at}}</td>
      
        <td>{{ $user->nombre}}</td>
        <td>{{ $user->apellido}}</td>
        <td>{{ $user->ncarne}}</td>
        
        
        <td><a href="{{ URL::to('repartidor/' . $user->id) }}" target="_self"><span class="label label-info">Actualizar</span></a>
            <a href="{{ URL::to('repartidord/' . $user->id) }}" target="_self"><span class="label label-warning">Eliminar</span></a>
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