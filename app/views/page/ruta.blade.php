@extends('layouts.master')

@section('content')
<script>
function goBack() {
    window.history.back()
}
</script>


<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Ruta</h4></div>
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

    <form action="{{ URL::route('ruta') }}" class="form-horizontal" method="post" role="form">
      

      
      <div class="form-group">
        <label for="marcacion" class="col-sm-2 control-label">Cliente</label>
        <div class="col-sm-8">
          
          <select name="cliente_id" id="cliente_id"  class="form-control">
              @foreach ($clientes as $cliente)
      
        
        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
      
      @endforeach
              
              
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="marcacion" class="col-sm-2 control-label">Repartidor</label>
        <div class="col-sm-8">
          
          <select name="repartidor_id" id="repartidor_id"  class="form-control">
              @foreach ($repartidores as $repartidor)
      
        
        <option value="{{ $repartidor->id }}">{{ $repartidor->nombre }}</option>
      
      @endforeach
              
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label for="pedido" class="col-sm-2 control-label">Pedido</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="pedido" id="pedido" placeholder="Pedido" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="nfactura" class="col-sm-2 control-label">Número Factura</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="nfactura" id="nfactura" placeholder="factura" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="norden" class="col-sm-2 control-label">Número Orden</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="norden" id="norden" placeholder="Pedido" value="">
        </div>
      </div>

      <div class="form-group">
        <label for="nhr" class="col-sm-2 control-label">Número HR</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="nhr" id="nhr" placeholder="HR" value="">
        </div>
      </div>
      
       

     

     
     



      <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
  </div>
</div>
@stop