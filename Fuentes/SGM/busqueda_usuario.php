<?php

require ("cabecera.php");
include ("menu.php");

if(!ValidaAcceso("busqueda_usuario.php", $_SESSION["paginas"]))
{
	echo $V_ACCES_DENIED;
	exit();
}

?>

<script type="text/javascript" >
    var validoRut = false;

	$(function() {
	    
	    $("#collapse<?php echo "3"; ?>").collapse('show');
        $("#busqueda_usuario").addClass("btn-info");

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
			"sAjaxSource" : './BO/BuscaUsuarios.php', // fuente del json
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
		
		$("#btnBuscar").click(function(){
		    
		    if(ValidarFiltros())
		    {
                oTabla.fnReloadAjax(); 
		    }
		});
		
		$('#txtRut').Rut({
            validation: true,
            format_on: 'keyup',
            on_error: function(){
                validoRut = false;
            },
            on_success: function(){
                validoRut = true;
            }
        });
		
		$("#btnLimpiar").click(function(){
            $("#txtRut").val("");
            $("#txtNombre").val("");
            $("#txtFechaInicioDesde").val("");
            $("#txtFechaInicioHasta").val("");
            validoRut = false;
            oTabla.fnReloadAjax();
        });

	}); 
	
	function ValidarFiltros()
	{
		var errores = [];
		
	    var txtRut = $("#txtRut").val();
	    if(txtRut != ""){
	    	if(!validoRut){
                errores.push(" - El rut es inválido.");
            }
	    }
	    
	    var txtNombre = $("#txtNombre").val();
	    if(txtNombre != ""){
	    	if(!ValidaTexto(txtNombre, 255)){
	    		errores.push(" - El nombre es inválido.");
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
	
	function ModificarUsuario(idUsuario)
	{
	    $().redirect('modificar_usuario.php', {'idUsuario': idUsuario});
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
			<label>Rut</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_RUT; ?>" class="input-xlarge" id="txtRut" name="txtRut">
		</div>
		<div class="span5">
			<label>Nombre Usuario</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombre" name="txtNombre">
		</div>
		<div class="span1"></div>
	</div>
	<div class="row-fluid filtroAvanzado">
		<div class="span1"></div>
		<div class="span5">
			<label>Fecha de Creación Desde</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioDesde" name="txtFechaInicioDesde">
		</div>
		<div class="span5">
	        <label>Fecha de Creación Hasta</label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioHasta" name="txtFechaInicioHasta">
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

<fieldset>
	<legend>
		Resultados
	</legend>
	<div class="row-fluid">
		<div  class="span12">
			<table id="tblResultados" class="table table-striped table-bordered ">
				<thead>
					<tr>
						<th>Rut</th>
						<th>Nombre(s)</th>
						<th>Apellido(s)</th>
						<th>Correo</th>
						<th>Telefóno</th>
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

