@extends('layouts.master')

@section('content')





<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Info Detalle</h4></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      @foreach ($users as $user)
      <tr>
        <th>ID</th>
        <td>{{ $user->ruta_id}}</td>  
      </tr>
      <tr>
        <th>Fecha creación</th>
        <td>{{ $user->created_at}}</td>
        </tr>
      <tr>
        <th class="entrega" style="background:#dedede;">Fecha actualización</th>
        <td>{{ $user->updated_at}}</td>
        </tr>
      <tr>
        <th>Ruta N.</th>
        <td>{{ $user->nrutas}}</td>
        </tr>
      <tr>
        <th>Nombre</th>
        <td>{{ $user->nombre}}</td>
        </tr>
      <tr>
        <th>Direcci&oacute;n</th>
        <td>{{ $user->direccion}}</td>
        </tr>
      <tr>
        
        
        <th>Cuenta</th>
        <td>{{ $user->ncuenta}}</td>
        </tr>
      <tr>
        <th>Pedido</th>
        <td>{{ $user->pedido}}</td>
        </tr>
      <tr>
        <th>Dirección de Entrega</th>
        <td>{{ $user->direc}}</td>
        </tr>
      <tr>
        <th>Número Factura</th>
        <td>{{ $user->nfactura}}</td>
        </tr>
      <tr>
        <th>Número Orden</th>
        <td>{{ $user->norden}}</td>
        </tr>
      <tr>
        <th>Número sHR</th>
        <td>{{ $user->nhr}}</td>
        </tr>
      <tr>

        <th class="entrega" style="background:#dedede;">Piloto</th>
         <td>{{ $user->rname}} {{ $user->apellido}}</td>
        </tr>
      <tr>
        <th class="entrega" style="background:#dedede;">Estado</th>
        <td>{{ $user->estado}}</td>
        </tr>
      <tr>
        <th class="entrega" style="background:#dedede;">Comentario</th>
        <td>{{ $user->comentario}}</td>
        </tr>
      <tr>
        <th class="entrega" style="background:#dedede;">Ubicación entregado</th>
        <td>{{ $user->checkP}}</td>
        </tr>
      <tr>
        <th class="entrega" style="background:#dedede;">Foto</th>
        <td><a href="http://tools.mobiletarget.me/json/{{ $user->img}}" target="_self"><img src = "http://tools.mobiletarget.me/json/{{ $user->img}}"></img></a></td>
        </tr>
   
      
      
      @endforeach
    </table>
  </div>
</div>



@stop