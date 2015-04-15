@extends('layouts.master')

@section('content')
<div class="searchmounth">
  <div class="form-group">
  <label for="pmes" class="col-sm-7 control-label"><h2>Elige los meses</h2></label>
 
      <label for="pmes" class="col-sm-7 control-label">Primer mes</label>
      <div class="col-sm-7">
          <select name="pmes" id="pmes"  class="form-control">
                            
                                   <option value="01">Enero</option>
                                   <option value="02">Febrero</option>
                                   <option value="03">Marzo</option>
                                   <option value="04">Abril</option>
                                   <option value="05">Mayo</option>
                                   <option value="06">Junio</option>
                                   <option value="07">Julio</option>
                                   <option value="08">Agosto</option>
                                   <option value="09">Septiembre</option>
                                   <option value="10">Octubre</option>
                                   <option value="11">Nomviembre</option>
                                   <option value="12">Diciembre</option>
           </select>
        </div>
    
  </div>  
    <div class="form-group">
        <label for="smes" class="col-sm-7 control-label">Segundo mes</label>
        <div class="col-sm-7">
          <select name="smes" id="smes"  class="form-control">
                            
                                   <option value="01">Enero</option>
                                   <option value="02">Febrero</option>
                                   <option value="03">Marzo</option>
                                   <option value="04">Abril</option>
                                   <option value="05">Mayo</option>
                                   <option value="06">Junio</option>
                                   <option value="07">Julio</option>
                                   <option value="08">Agosto</option>
                                   <option value="09">Septiembre</option>
                                   <option value="10">Octubre</option>
                                   <option value="11">Nomviembre</option>
                                   <option value="12">Diciembre</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="tmes" class="col-sm-7 control-label">Tercer mes</label>
        <div class="col-sm-7">
           <select name="tmes" id="tmes"  class="torm-control">
                            
                                   <option value="01">Enero</option>
                                   <option value="02">Febrero</option>
                                   <option value="03">Marzo</option>
                                   <option value="04">Abril</option>
                                   <option value="05">Mayo</option>
                                   <option value="06">Junio</option>
                                   <option value="07">Julio</option>
                                   <option value="08">Agosto</option>
                                   <option value="09">Septiembre</option>
                                   <option value="10">Octubre</option>
                                   <option value="11">Nomviembre</option>
                                   <option value="12">Diciembre</option>
          </select>
        </div>
      </div>

       <div class="form-group">
        <label for="ano" class="col-sm-7 control-label">Año</label>
        <div class="col-sm-7">
           <select name="ano" id="ano"  class="torm-control">
                            
                                   <option value="2014">2014</option>
                                   <option value="2015">2015</option>
                                   
          </select>
        </div>
      </div>
  <button type="submit" class="btn btn-primary" onclick="trackChangev(document.getElementById('pmes').value,document.getElementById('smes').value,document.getElementById('tmes').value,document.getElementById('ano').value)">Buscar</button>
     <script>
         function trackChangev(valueu, valued, valuet,ano)
         {
            window.open("/report/"+valueu+"/"+valued+"/"+valuet+"/"+ano)
         }
     </script>
</div>

@stop