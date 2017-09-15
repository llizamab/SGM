<?php

require ("cabecera.php");
include ("menu.php");

if (!ValidaAcceso("situacion_actual.php", $_SESSION["paginas"])) {
    echo $V_ACCES_DENIED;
    exit();
}

?>

<script type="text/javascript" >

    var grafico = null;
    
    $(function() {
        
        $("#collapse<?php echo "5"; ?>").collapse('show');
        $("#situacion_actual").addClass("btn-info");
        
        $("#btnBuscar").click(function() {
            $.post("./BO/BuscaSituacionActual.php", $('#FormPrincipal').serialize(),
                function(data) {
                    var obj = jQuery.parseJSON(data);
                    var msj = obj.html;
                    var sub_msj = obj.errores;
                    var estado =  obj.estado;
                    if(estado == 'OK') // Exito
                    {
                        grafico = obj.array;
                        drawChart();
                    }
                    else // Error
                    {
                        MostrarError(msj, sub_msj);
                    }
            });
        });
        
        $("#btnLimpiar").click(function() {
            
            $('.selectpicker').selectpicker('deselectAll');
            $("#btnBuscar").click();
        });
        
        $("#btnBuscar").click();
    });
    
</script>

<script type="text/javascript" src="js/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['gauge']});
  google.setOnLoadCallback(drawChart);
  
  function drawChart() {
      
    var gD = <?php echo $V_GD; ?>;
    var gH = <?php echo $V_GH; ?>;
    var yD = <?php echo $V_YD; ?>;
    var yH = <?php echo $V_YH; ?>;
    var rD = <?php echo $V_RD; ?>;
    var rH = <?php echo $V_RH; ?>;
    var Mx = <?php echo $V_MX; ?>;
    
    console.debug;
    if(grafico != null)
    {       
       var data = google.visualization.arrayToDataTable([
           ['Label', 'Value'],
           ['Alta', grafico[3]],
           ['Media', grafico[2]],
           ['Baja', grafico[1]]
        ]);

        var options = {
          width: 600, height: 220,
          redFrom: rD, redTo: rH,
          yellowFrom: yD, yellowTo: yH,
          greenFrom: gD, greenTo: gH,
          greenColor: '#20b2aa',
          minorTicks: 3,
          min: 0,
          max: Mx
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div0'));
        chart.draw(data, options);
    }
  }
</script>
<!--  -->
<fieldset>
    <legend>Filtros de Búsqueda</legend>

    <div class="row-fluid">
        <div class="span1"></div>
        <div class="span5">
            <?php
            $obj = new Utilidades($V_HOST, $V_USER, $V_PASS, $V_BBDD);
            echo $obj->GeneraSelectProyectos("ddlProyecto", true, true, 5);
            ?>
        </div>
        <div class="span5">
            <?php
            echo $obj->GeneraSelectClientes("ddlCliente", true, true, 5);
            ?>
        </div>
        <div class="span1"></div>
    </div>
</fieldset>
<div>
    &nbsp;
</div>
<div class="row-fluid">
    <div class="container theme-showcase pagination-centered">
        <p>
            <button type="button" class="btn btn-lg btn-primary" id="btnBuscar">
                Buscar
            </button>
            <button type="button" class="btn btn-lg btn-primary" id="btnLimpiar">
                Limpiar
            </button>
        </p>
    </div>
</div>

<div id="divErrores" style="width: 70%;"></div>

<fieldset>
    <legend>Resultados por Prioridad</legend>
    <div class="row-fluid">
        <div class="span1">
        </div>
        <div class="span10">
            <div id="graficos">
                 <div id="chart_div0" style="width: 100%; height: 600px;"></div>
            </div>
        </div>
        <div class="span1">
        </div>
    </div>
</fieldset>

<div>
    &nbsp;
</div>
<div>
    &nbsp;
</div>

<!-- Hiddens -->
<div style="display: none;">
    
</div>

<?php

include ("footer.php");
?>



