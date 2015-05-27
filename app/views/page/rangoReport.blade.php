@extends('layouts.master')

@section('content')
<div class="searchmounth">
   <!--Repartidor-->
      <div class="form-group">
        <label for="marcacion" class="col-sm-2 control-label">Repartidor</label>
        <div class="col-sm-8">
          
          <select name="repartidor_id" id="repartidor_id"  class="form-control">
              @foreach ($repartidores as $repartidor)
      
        
        <option value="{{ $repartidor->id }}">{{ $repartidor->nombre }} {{ $repartidor->apellido }}</option>
      
      @endforeach
              
              
          </select>
        </div>
      </div>
 

      

       
  <button type="submit" class="btn btn-primary" onclick="trackChangev(document.getElementById('repartidor_id').value)">Descargar</button>
     <script>
         function trackChangev(valueu)
         {
            window.open("/exportRep/"+valueu)
         }
     </script>
</div>

@stop