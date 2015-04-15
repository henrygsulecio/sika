@extends('layouts.master')

@section('content')

<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Record</h4></div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12"><h4 class="resum bg-primary">Validos</h4></div>
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Tel&eacute;fono</th> 
        
        <th>Texto</th>
        <th>Compra</th>
        <th>Puntos</th> 
        
   
      </tr>
      @foreach ($valid as $val)
      <tr>
        <td>{{ $val->created_at}}</td>
        <td>{{ $val->firstname}}</td>
        <td>{{ $val->lastname}}</td>
        <td>{{ $val->phone}}</td>
        
        <td>{{ $val->code}}</td>
        <td>
          @if (!$val->code==NULL)
              @if (strpos($val->code, "C")===0) 
                   Cubeta
              @else
              
                   Galon
              @endif
          @endif
          
           </td>
         
          <td>@if (!$val->code==NULL)
              @if (strpos($val->code, "C")===0) 
                   50
              @else
              
                   20
              @endif
          @endif
           </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>


<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-12"><h4 class="resum bg-primary">Todos los enviados</h4></div>
    <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
      <tr>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Tel&eacute;fono</th> 
        
        <th>Texto</th>
       
        
   
      </tr>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->created_at}}</td>
        <td>{{ $user->firstname}}</td>
        <td>{{ $user->lastname}}</td>
        <td>{{ $user->phone}}</td>
        
        <td>{{ $user->msg}}</td>
        
      </tr>
      @endforeach
    </table>
  </div>
</div>
<div class="row">
  <div class="col-xs-5">
    {{ $users->links() }}
  </div>
</div>
