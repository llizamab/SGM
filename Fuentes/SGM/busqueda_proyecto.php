<?php

require ("cabecera.php");
include ("menu.php");

if(!ValidaAcceso("busqueda_proyecto.php", $_SESSION["paginas"]))
{
	echo $V_ACCES_DENIED;
	exit();
}

?>

<script type="text/javascript" >
	$(function() {
	    
	    $("#collapse<?php echo "1"; ?>").collapse('show');
	    $("#busqueda_proyecto").addClass("btn-info");

		var oTabla = $('#tblResultados').dataTable({
			bJQueryUI : true,
			sPaginationType : "full_numbers", //tipo de paginacion
			"bFilter" : false, // muestra el cuadro de busqueda
			"iDisplayLength" : 5, // cantidad de filas que muestra
			"bLengthChange" : false, // cuadro que deja cambiar la cantidad de filas
			"oLanguage" : {// mensajes y el idio,a
				"sLengthMenu" : "Mostrar _MENU_ registros",
				"sZeroRecords" : "No hay resultados",
				"sInfo" : "Resultados del _START_ al _END_ de _TOTAL_ registros",
				"sInfoEmpty" : "0 Resultados",
				"sInfoFiltered" : "(filtrado desde _MAX_ registros)",
				"sInfoPostFix" : "",
				"sSearch" : "Buscar:",
				"sUrl" : "",
				"sInfoThousands" : ",",
				"sLoadingRecords" : "Cargando...",
				"oPaginate" : {
					"sFirst" : "Primero",
					"sLast" : "Último",
					"sNext" : "Siguiente",
					"sPrevious" : "Anterior"
				}
			},
			"bProcessing" : true, //para procesar desde servidor
			"sServerMethod" : "POST",
			"sAjaxSource" : './BO/BuscaProyectos.php', // fuente del json
			"fnServerData" : function(sSource, aoData, fnCallback) {// Para buscar con el boton
				$.ajax({
					"dataType" : 'json',
					"type" : "POST",
					"url" : sSource,
					"data" : $('#FormPrincipal').serialize(),
					"success" : fnCallback
				});
			}
		});
		
		$("#btnBuscarProyecto").click(function(){
		    
		    if(ValidarFiltros())
		    {
                oTabla.fnReloadAjax(); 
		    }
		});
		
		$("#btnLimpiarProyecto").click(function(){
            $("#txtCodigoProyecto").val("");
            $("#txtNombreProyecto").val("");
            $("#txtFechaInicioDesde").val("");
            $("#txtFechaTerminoDesde").val("");
            $("#txtFechaGarantiaDesde").val("");
            $("#txtFechaInicioHasta").val("");
            $("#txtFechaTerminoHasta").val("");
            $("#txtFechaGarantiaHasta").val("");
            $("#ddlDestacado").val("");
            $("#ddlJefeProyecto").val("");
            $("#ddlCliente").val("");
            $("#ddlTipoProyecto").val("");
            $('.selectpicker').selectpicker('deselectAll');
            oTabla.fnReloadAjax();
        });

	}); 
	
	function ValidarFiltros()
	{
		var errores = [];
		
	    var txtCodigoProyecto = $("#txtCodigoProyecto").val();
	    if(txtCodigoProyecto != ""){
	    	if(!ValidaNumerico(txtCodigoProyecto)){
	    		errores.push(" - El código de proyecto es inválido.");
	    	}
	    }
	    
	    var txtNombreProyecto = $("#txtNombreProyecto").val();
	    if(txtNombreProyecto != ""){
	    	if(!ValidaTexto(txtNombreProyecto, 100)){
	    		errores.push(" - El nombre de proyecto es inválido.");
	    	}
	    }

	    if(errores.length > 0)
		{
			MostrarError("Datos incorrectos, ingrese nuevamente lo siguiente:",errores);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function ModificarProyecto(idProyecto)
	{
	    $().redirect('modificar_proyecto.php', {'idProyecto': idProyecto});
	}
	
	function NoDestacarProyecto(idProyecto)
	{
		var opcion = $("#fila"+idProyecto).val();
		
		if(opcion != "0")
		{
			MarcarProyecto(idProyecto,0);
			$("#fila"+idProyecto).removeClass("icon-star").addClass("icon-star-empty");
			$("#fila"+idProyecto).val("0");	
		}
		else
		{
			MarcarProyecto(idProyecto,1);
			$("#fila"+idProyecto).removeClass("icon-star-empty").addClass("icon-star");
			$("#fila"+idProyecto).val("1");
		}
	}
	
	function DestacarProyecto(idProyecto)
	{
		var opcion = $("#fila"+idProyecto).val();
		
		if(opcion == "1")
		{
			MarcarProyecto(idProyecto,0);
			$("#fila"+idProyecto).removeClass("icon-star").addClass("icon-star-empty");
			$("#fila"+idProyecto).val("0");
		}
		else
		{
			MarcarProyecto(idProyecto,1);
			$("#fila"+idProyecto).removeClass("icon-star-empty").addClass("icon-star");
			$("#fila"+idProyecto).val("1");
		}
    }
    
    function MarcarProyecto(idProyecto, marca){
    	$.post("./BO/MarcarProyecto.php", {idProyecto: idProyecto, marca: marca});
    }
</script>

<!--  -->
<fieldset>
	<legend>Filtros de Búsqueda</legend>
	
	<div id="divErrores" style="width: 60%;"></div>
	
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
			<label>Código Proyecto</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_NUMERO; ?>" class="input-xlarge" id="txtCodigoProyecto" name="txtCodigoProyecto">
			<label>Nombre Proyecto</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreProyecto" name="txtNombreProyecto">
		</div>
		<div class="span5">
<?php
    $obj = new Utilidades($V_HOST,$V_USER,$V_PASS,$V_BBDD);
    
    echo $obj->GeneraSelectEncargado("ddlJefeProyecto", true, true, 5);
    
    echo $obj->GeneraSelectClientes("ddlCliente", true,true,5);
 ?>
		</div>
		<div class="span1"></div>
	</div>
	<div class="row-fluid filtroAvanzado">
		<div class="span1"></div>
		<div class="span5">
			<label>Fecha de Inicio Desde</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioDesde" name="txtFechaInicioDesde">
            <label>Fecha de Término Desde</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaTerminoDesde" name="txtFechaTerminoDesde">
            <label>Fecha de Garantía Desde</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaGarantiaDesde" name="txtFechaGarantiaDesde">
            
<?php
    echo $obj->GeneraSelectDestacado("ddlDestacado");
    echo $obj->GeneraSelectEstadoProyecto("ddlEstadoProyecto", true,true,5);
 ?>
		</div>
		<div class="span5">
	        <label>Fecha de Inicio Hasta</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioHasta" name="txtFechaInicioHasta">
            <label>Fecha de Término Hasta</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaTerminoHasta" name="txtFechaTerminoHasta">
            <label>Fecha de Garantía Hasta</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaGarantiaHasta" name="txtFechaGarantiaHasta">
            
<?php
    echo $obj->GeneraSelectTipoProyecto("ddlTipoProyecto", true,true,5);
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
			<button type="button" class="btn btn-lg btn-primary" id="btnBuscarProyecto">
				Buscar
			</button>
			<button type="button" class="btn btn-lg btn-primary" id="btnLimpiarProyecto">
				Limpiar
			</button>
		</p>
	</div>
</div>

<fieldset>
	<legend>
		Resultados
	</legend>
	<div class="row-fluid">
		<div  class="span12">
			<table id="tblResultados" class="table table-striped table-bordered ">
				<thead>
					<tr>
						<th>Dest.</th>
						<th>Código</th>
						<th>Nombre Proyecto</th>
						<th>Tipo</th>
						<th>Estado</th>
						<th>Inicio</th>
						<th>Término</th>
						<th>Garantía</th>
						<th>Cliente</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	<fieldset>

		<div>
			&nbsp;
		</div>
		<div>
			&nbsp;
		</div>

		<?php

        include ("footer.php");
		?>

