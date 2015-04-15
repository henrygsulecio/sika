@extends('layouts.master')

@section('content')
      
<div class="row">
  <div class="col-xs-27"><h4 class="resum bg-primary">Info</h4></div>
</div>
<div class="row">
  <div class="col-xs-27">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th style="text-align:center;" COLSPAN="3">Datos</th>
        <th style="text-align:center;" COLSPAN="2">Mes {{$mest}}</th>
        <th style="text-align:center;" COLSPAN="2">Mes {{$mesd}}</th>
        <th style="text-align:center;" COLSPAN="2">Mes {{$mesu}}</th>
   
      </tr>

      <tr>
        
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Tel&eacute;fono</th>
        
        <th>Compra Galon</th>
        <th>Compra Cubeta</th>

        <th>Compra Galon</th>
        <th>Compra Cubeta</th>

        <th>Compra Galon</th>
        <th>Compra Cubeta</th>
        
        <th>Acciones</th>
        <th></th>
      </tr>
      </tr>
     
      @foreach ($pm as $userp)
      <tr>
       <td>{{ $userp->lastname}}</td>
       <td>{{ $userp->firstname}}</td>
       <td><a href="{{ URL::to('record/' . $userp->phone) }}">{{ $userp->phone}}</a></td>
       
       <td>{{ $userp->galonest}}</td>
       <td>{{ $userp->cubetast}}</td>

       <td>{{ $userp->galonesd}}</td>
       <td>{{ $userp->cubetasd}}</td>

       <td>{{ $userp->galonesu}}</td>
       <td>{{ $userp->cubetasu}}</td>
      
      <td><a href="{{ URL::to('user/' . $userp->user_id) }}"><span class="label label-info">Actualizar</span></a></td>
      <td></td>
     </tr>
      @endforeach
      
    </table>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    {{ $pm->links() }}
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12">
    <button type="button" class="btn btn-default btn-lg">
         <a href="{{ URL::to('exportReport') }}/{{$mesu}}/{{$mesd}}/{{$mest}}/{{$ano}}"><span class"glyphicon glyphicon-star">Descargar .csv</span></a>
    </button>
  </div>
</div>
</div>


@stop