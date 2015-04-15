@extends('layouts.master')

@section('content')
<script>
function goBack() {
    window.history.back()
}
</script>


<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Usuario</h4></div>
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

    <form action="{{ URL::route('reguardStatus') }}" class="form-horizontal" method="post" role="form">
      <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

      <div class="form-group">

        <label for="phone" class="col-sm-2 control-label">Telefono</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="phone" id="phone" placeholder="Telefono" value="{{ $user->phone }}">
        </div>
      </div>
       <div class="form-group">

        <label for="code" class="col-sm-2 control-label">Code</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="code" id="code" placeholder="code" value="{{ $user->codigo }}">
        </div>
      </div>
      

<div class="form-group">
        <label for="status" class="col-sm-2 control-label">Estado</label>
        <div class="col-sm-8">
          <label for="status" class="col-sm-4 control-label">Actual: {{ $user->estado }}</label>
          <select name="status" id="status"  class="form-control">
              <option value="ninguno">ninguno</option>
              <option value="activo">Activo</option>
              <option value="inactivo">Inactivo</option>
              
          </select>
        </div>
      </div>

   

      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop