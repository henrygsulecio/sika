@extends('layouts.master')

@section('content')
<script>
function goBack() {
    window.history.back()
}
</script>


<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Usuarios</h4></div>
</div>

<div class="row">
  <div class="col-xs-12">
    @if (Session::has('result'))
    <div class="alert alert-success text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      {{ @Session::get('result') }}
    </div>
    @endif

    @if (Session::has('mensaje'))
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

    <form action="{{ URL::route('usuario') }}" class="form-horizontal" method="post" role="form">
      

      
      <div class="form-group">

        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="">
        </div>
      </div>
      
      <div class="form-group">
        <label for="license" class="col-sm-2 control-label">Nickname</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="nickname" id="nickname" placeholder="nickname" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="telefono" class="col-sm-2 control-label">password</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="password" id="password" placeholder="password" value="">
        </div>
      </div>
      
       

     

     
     



      <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
  </div>
</div>
@stop