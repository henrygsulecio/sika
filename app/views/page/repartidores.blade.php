@extends('layouts.master')

@section('content')
<script>
function goBack() {
    window.history.back()
}
</script>


<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Repartidor</h4></div>
</div>
<button type="button" class="btn-primary" data-dismiss="alert" onclick="goBack()">Regresar</button>
<div class="row">
  <div class="col-xs-12">
    @if (Session::has('result'))
    <div class="alert alert-success text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      {{ @Session::get('result') }}
    </div>
    @endif

    @if (Session::has('repartidor'))
    <div class="alert alert-danger text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      {{ @Session::get('mensaje') }}
    </div>
    @endif
        
        <script type="text/javascript">
              window.setTimeout(function() {
              $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
              });
              }, 3000);
        </script>

    <form action="{{ URL::route('repartidor') }}" class="form-horizontal" method="post" role="form">
      <input type="hidden" name="id" id="id" value="{{ $user->id }}">

      
      <div class="form-group">

        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="">
        </div>
      </div>
      
      <div class="form-group">

        <label for="apellido" class="col-sm-2 control-label">Apellido</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" value="">
        </div>
      </div>
      
      
       <div class="form-group">
        <label for="ncarne" class="col-sm-2 control-label">Número Ruta</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="ncarne" id="ncarne" placeholder="Número Ruta" value="">
        </div>
      </div>

     

     
     



      <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
  </div>
</div>
@stop