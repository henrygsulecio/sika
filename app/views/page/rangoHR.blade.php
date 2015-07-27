@extends('layouts.master')

@section('content')
<div class="searchmounth">
   <!--Repartidor-->
      <div class="form-group">
        <label for="marcacion" class="col-sm-2 control-label">HR</label>
        <div class="col-sm-8">
          
          <select name="HR" id="HR"  class="form-control">
              @foreach ($repartidores as $repartidor)
      
        
        <option value="{{ $repartidor->nhr }}">{{ $repartidor->nhr }}</option>
      
      @endforeach
              
              
          </select>
        </div>
      </div>
 

      

       
  <button type="submit" class="btn btn-primary" onclick="trackChangev(document.getElementById('HR').value)">Descargar</button>
     <script>
         function trackChangev(valueu)
         {
            window.open("/exportHR/"+valueu)
         }
     </script>
</div>

@stop