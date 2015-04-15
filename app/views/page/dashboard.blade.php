@extends('layouts.master')

@section('css-site')
{{ HTML::style('css/' . $page . '.css') }}
@overwrite

@section('js-site')
{{ HTML::script('js/' . $page . '.min.js') }}
<script type="text/javascript">
(function ($) {
  var ctx;

  $(document).ready(function() {
    ctx = $("#traffic").get(0).getContext("2d");
    var data = {
      labels : [
        @foreach ($traffic as $row)
          @if (!$row->first)
            ,
          @endif
          '{{ $row->day }}'
        @endforeach
      ],
      datasets : [
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          pointColor : "rgba(220,220,220,1)",
          pointStrokeColor : "#fff",
          data : [
            @foreach ($traffic as $row)
              @if (!$row->first)
                ,
              @endif
              {{ $row->messages }}
            @endforeach
          ]
        },
        {
          fillColor : "rgba(131,139,131,0.5)",
          strokeColor : "rgba(131,139,131,1)",
          pointColor : "rgba(131,139,131,1)",
          pointStrokeColor : "#fff",
          data : [
            @foreach ($traffic as $row)
              @if (!$row->first)
                ,
              @endif
              {{ $row->users }}
            @endforeach
          ]
        }
      ]
    };
    var options = {};
    var myNewChart = new Chart(ctx).Line(data,options);
  });
})(jQuery);
</script>
@overwrite

@section('highlight')
<div id="highlight">
  <div class="container">
    <div class="row">
      <div class="table-responsive text-center">
        <canvas id="traffic" width="950" height="400"></canvas>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 col-sm-3 col-sm-offset-3">
        <span class="messages"><span class="icon"></span>Tr&aacute;fico</span>
      </div>
      <div class="col-xs-4 col-sm-3">
        <span class="users"><span class="icon"></span>Participantes</span>
      </div>
    </div>
  </div>
</div>
@stop

@section('content')
<div class="row">
  <div class="col-xs-12"><h4 class="resum bg-primary">Resumen de Promoci&oacute;n</h4></div>
</div>
<div class="row">
  <div class="col-sm-6">
    <table class="table table-hover table-condensed">
      <tr>
        <th colspan="2">Toda la Promoci&oacute;n</th>
      </tr>
      <tr>
        <td>Total de SMS Generados</td>
        <td>{{ number_format($resum_all->messages) }}</td>
      </tr>
      <tr>
        <td>Total Usuarios</td>
        <td>{{ number_format($resum_all->users) }}</td>
      </tr>
      <tr>
        <td>Playrate MO</td>
        <td>{{ number_format($resum_all->playrate, 2) }}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <th colspan="2">Resumen por Operadores</th>
      </tr>
      <tr>
        <td>Tigo MO</td>
        <td>{{ number_format($resum_telcos->tigo) }}</td>
      </tr>
      <tr>
        <td>Claro MO</td>
        <td>{{ number_format($resum_telcos->claro) }}</td>
      </tr>
      <tr>
        <td>Movistar MO</td>
        <td>{{ number_format($resum_telcos->movistar) }}</td>
      </tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-hover table-condensed">
      <tr>
        <th colspan="2">Ultimos 7 d&iacute;as</th>
      </tr>
      <tr>
        <td>Mensajes SMS Generados</td>
        <td>{{ number_format($resum_week->messages) }}</td>
      </tr>
      <tr>
        <td>Total Usuarios</td>
        <td>{{ number_format($resum_week->users) }}</td>
      </tr>
      <tr>
        <td>Playrate MO</td>
        <td>{{ number_format($resum_week->playrate, 2) }}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <th colspan="2">Hoy</th>
      </tr>
      <tr>
        <td>Mensajes SMS Generados</td>
        <td>{{ number_format($resum_today->messages) }}</td>
      </tr>
      <tr>
        <td>Total Usuarios</td>
        <td>{{ number_format($resum_today->users) }}</td>
      </tr>
      <tr>
        <td>Playrate MO</td>
        <td>{{ number_format($resum_today->playrate, 2) }}</td>
      </tr>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-xs-12"><p><small><strong>Nota: Toda la informaci&oacute;n se actualiza cada {{ $cache_time }} minutos.</strong></small></p></div>
</div>
@stop