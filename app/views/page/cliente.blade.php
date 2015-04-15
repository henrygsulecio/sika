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

    <form action="{{ URL::route('cliente') }}" class="form-horizontal" method="post" role="form">
      <input type="hidden" name="user_id" id="user_id" value="">

      <div class="form-group">

        <label for="phone" class="col-sm-2 control-label">Telefono</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="phone" id="phone" placeholder="Telefono" value="">
        </div>
      </div>
      <div class="form-group">

        <label for="firstname" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Nombre" value="">
        </div>
      </div>
      <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">Apellido</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellido" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="dpi" class="col-sm-2 control-label">DPI</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="dpi" id="dpi" placeholder="DPI" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="birthday" class="col-sm-2 control-label">Fecha de Nacimiento</label>
        <div id="datetimepicker" class="input-append date col-sm-8">
           <input type="text" class="form-control" name="birthday" id="birthday" placeholder="Fecha de Nacimiento" value=""></input>
           <span class="add-on">
              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
           </span>
        </div>
    
          <script type="text/javascript">
              $('#datetimepicker').datetimepicker({
              format: 'yyyy/MM/dd',
              language: 'Es'
          });
          </script>
      </div>

      <div class="form-group">
        <label for="license" class="col-sm-2 control-label">Licencia</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="license" id="license" placeholder="Licencia" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="vehicle" class="col-sm-2 control-label">Vehiculo</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="vehicle" id="vehicle" placeholder="Vehiculo" value="">
        </div>
      </div>

<div class="form-group">
        <label for="location" class="col-sm-2 control-label">Ubicaci&oacute;n</label>
        <div class="col-sm-8">
          <label for="location" class="col-sm-4 control-label">Actual: {{ $user->location }}</label>
          <select name="location" id="location"  class="form-control">
              <option value="ninguno">ninguno</option>
              <option value="Peten">Petén</option>
              <option value="Huehuetenango">Huehuetenango</option>
              <option value="Quiche">Quiché</option>
              <option value="Alta Verapaz">Alta Verapaz</option>
              <option value="Izabal">Izabal</option>
              <option value="San Marcos">San Marcos</option>
              <option value="Quetzaltenango">Quetzaltenango</option>
              <option value="Totonicapan">Totonicapán</option>
              <option value="Solola">Sololá</option>
              <option value="Chimaltenango">Chimaltenango</option>
              <option value="Sacatepequez">Sacatepéquez</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Baja Verapaz">Baja Verapaz</option>
              <option value="El Progreso">El Progreso</option>
              <option value="Jalapa">Jalapa</option>
              <option value="Zacapa">Zacapa</option>
              <option value="Chiquimula">Chiquimula</option>
              <option value="Retalhuleu">Retalhuleu</option>
              <option value="Suchitepequez">Suchitepéquez</option>
              <option value="Escuintla">Escuintla</option>
              <option value="Santa Rosa">Santa Rosa</option>
              <option value="Jutiapa">Jutiapa</option>
          </select>
        </div>
      </div>

      <!--<div class="form-group">
        <label for="location" class="col-sm-2 control-label">Ubicaci&oacute;n</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="location" id="location" placeholder="Ubicaci&oacute;n" value="{{ $user->location }}">
        </div>
      </div>-->

      <div class="form-group">
        <label for="tons" class="col-sm-2 control-label">Tons</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="tons" id="tons" placeholder="Tons" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="comments" class="col-sm-2 control-label">Comentario</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="comments" id="comments" placeholder="Comentario" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="workplace" class="col-sm-2 control-label">Lugar de trabajo</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="workplace" id="workplace" placeholder="Lugar de trabajo" value="">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop