<?php

require ("cabecera.php");
include ("menu.php");

if (!ValidaAcceso("ver_estadisticas.php", $_SESSION["paginas"])) {
	echo $V_ACCES_DENIED;
	exit();
}
?>

<script type="text/javascript" >

    var grafico = null;
    var proyectos = null;
    
	$(function() {
	    
	    $("#collapse<?php echo "5"; ?>").collapse('show');
        $("#ver_estadisticas").addClass("btn-info");
		
		$("#btnBuscar").click(function() {

			if (ValidarFiltros()) {
			    
			    $.post("./BO/BuscaEstadistica.php", $('#FormPrincipal').serialize(),
                    function(data) {
                        var obj = jQuery.parseJSON(data);
                        var msj = obj.html;
                        var sub_msj = obj.errores;
                        var estado =  obj.estado;
                        if(estado == 'OK') // Exito
                        {
                            $('#graficos').html("");
                            $("#graficos").append("<div id='chart_div0' style='width: 100%; height: 500px;'></div>");
                            grafico = obj.array;
                            proyectos = obj.proyectos;
                            drawChart();
                        }
                        else // Error
                        {
                            MostrarError(msj, sub_msj);
                        }
                    });
			}
		});
		

		$("#btnLimpiar").click(function() {
		    
		    $('#txtFechaInicioDesde').val("");
		    $('#txtFechaInicioHasta').val("");
		    $('.selectpicker').selectpicker('deselectAll');
			$('#graficos').html("");
			$("#graficos").append("<div id='chart_div0' style='width: 100%; height: 500px;'></div>");
		});

	});

	function ValidarFiltros() {
		var errores = [];

        var txtFechaInicio = $("#txtFechaInicioDesde").val();
        
        if(txtFechaInicio != "")
        {
            if(!ValidaFecha(txtFechaInicio)){
                errores.push(" - La fecha de inicio es inválida.");
            }
        }
          
        var txtFechaTermino = $("#txtFechaInicioHasta").val();
        
        if(txtFechaTermino != "")
        {  
            if(!ValidaFecha(txtFechaTermino)){
                errores.push(" - La fecha de termino es inválida.");
            }
        }
        
        if(txtFechaInicio != "" && txtFechaTermino != "")
        {
            if(ValidaFecha(txtFechaInicio) && ValidaFecha(txtFechaTermino) && !ValidaFechaDiff(txtFechaInicio, txtFechaTermino)){
                errores.push(" - La fecha de termino debe ser mayor a la de inicio.");
            }
        }

		if (errores.length > 0) {
			MostrarError("Datos incorrectos, ingrese nuevamente lo siguiente:", errores);
			return false;
		} else {
			return true;
		}
	}

</script>

<script type="text/javascript" src="js/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  
  function drawChart() {
    
    if(grafico != null)
    {
        var x = 0;
        for(var id_cliente in grafico){
            
            for(var id_proyecto in grafico[id_cliente]){
                
                var data = google.visualization.arrayToDataTable(grafico[id_cliente][id_proyecto]);
                var options = {
                  title: proyectos[id_proyecto]
                };
                
                $("#graficos").append("<div id='chart_div"+(x + 1)+"' style='width: 100%; height: 500px;'></div>");
            
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'+x));
                chart.draw(data, options);
                x++;
            }
        }
    }
  }
</script>
<!--  -->
<fieldset>
	<legend>
		Filtros de Búsqueda
	</legend>

	<div class="row-fluid">
		<div class="span9"></div>
		<div class="span2">
			<div id="txtbtnFiltros">
				Búsqueda Avanzada
			</div>
		</div>
		<div class="span1">
			<a class="btn btn-info" href="javascript:OcultaFiltros();"><i id="btnFiltros" class="icon-chevron-down"></i></a>
		</div>
	</div>
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
			echo $obj->GeneraSelectEstadoSolicitud("ddlEstadoSolicitud", true, true, 5);
			?>
		</div>
		<div class="span1"></div>
	</div>
	<div class="row-fluid filtroAvanzado">
		<div class="span1"></div>
		<div class="span5">
			<label>Fecha desde</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioDesde" name="txtFechaInicioDesde">
			<label>Fecha hasta</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioHasta" name="txtFechaInicioHasta">
		</div>
		<div class="span5">
			<?php
			echo $obj->GeneraSelectClientes("ddlCliente", true, true, 5);
            echo $obj->GeneraSelectTipoProyecto("ddlTipoProyecto", true, true, 5);
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
	<legend>
		Resultados
	</legend>
	<div class="row-fluid">
		<div class="span11">
		    <div id="graficos">
			     <div id="chart_div0" style="width: 100%; height: 500px;"></div>
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

