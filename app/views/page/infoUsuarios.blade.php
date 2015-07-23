@extends('layouts.master')

@section('content')


<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('usuario/') }}" target="_self"><span class"glyphicon glyphicon-star">Agregar Usuario</span></a>
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
        
        
        <th>Nombre</th>
        <th>Nickname</th>
        <th>id_repartidor</th>
        
        
        <th>Acciones</th>
        
        
      </tr>
      @foreach ($users as $user)
      <tr>
       <td>{{ $user->nombre}}</td>
      
        <td>{{ $user->nickname}}</td>
        <td>{{ $user->repartidor_id}}</td>
        
        
        
        <td><a href="{{ URL::to('usuario/' . $user->id) }}" target="_self"><span class="label label-info">Actualizar</span></a>
            <a href="{{ URL::to('usuariosd/' . $user->id) }}" target="_self"><span class="label label-warning">Eliminar</span></a>
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