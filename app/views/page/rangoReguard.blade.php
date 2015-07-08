@extends('layouts.master')

@section('content')
<div class="searchmounth">
  <br/>
  <div class="form-group">
        <label for="desde" class="col-sm-2 control-label">Desde</label>
        <div id="datetimepicker" class="input-append date col-sm-8">
           <input type="text" class="form-control" name="desde" id="desde" placeholder="desde" value=""></input>
           <span class="add-on">
              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
           </span>
        </div>
    
          <script type="text/javascript">
              $('#datetimepicker').datetimepicker({
              format: 'yyyy-MM-dd',
              language: 'Es'
          });
          </script>
      </div>
<br/>
  <div class="form-group">
        <label for="asta" class="col-sm-2 control-label">Hasta</label>
        <div id="datetimepickerd" class="input-append date col-sm-8">
           <input type="text" class="form-control" name="asta" id="asta" placeholder="asta" value=""></input>
           <span class="add-on">
              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
           </span>
        </div>
    
          <script type="text/javascript">
              $('#datetimepickerd').datetimepicker({
              format: 'yyyy-MM-dd',
              language: 'Es'
          });
          </script>
      </div>   
    <br/>
  <button type="submit" class="btn btn-primary" onclick="trackChangev(document.getElementById('desde').value,document.getElementById('asta').value)">Descargar</button>
     <script>
         function trackChangev(valueu,ano)
         {
            window.open("/exportFec/"+valueu+"/"+ano)
         }
     </script>
</div>

@stop