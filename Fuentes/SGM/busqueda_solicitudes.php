<?php

require ("cabecera.php");
include ("menu.php");

if (!ValidaAcceso("busqueda_solicitudes.php", $_SESSION["paginas"])) {
	echo $V_ACCES_DENIED;
	exit();
}

$roles = $_SESSION['roles'];
$soy_dev = false;

if(is_array($roles) && count($roles) == 1 && $roles[4] != ""){
    $soy_dev = true;
}

?>

<script type="text/javascript" >
	$(function() {
		
		$("#hdnIdUsuarioAux").val("<?php echo $_SESSION["id_usuario"] ?>");
		
		<?php
		if($soy_dev == TRUE){
	    ?>
	       $("#collapse1").collapse('show');
        <?php    
        } 
        else
        {
        ?>
            $("#collapse4").collapse('show');
        <?php
        }
        ?>

        $("#busqueda_solicitudes").addClass("btn-info");

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
			"aaSorting":[],
			"sServerMethod" : "POST",
			"sAjaxSource" : './BO/BuscaSolicitudes.php', // fuente del json
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

		$("#btnBuscar").click(function() {

			if (ValidarFiltros()) {
				$("#hdnIdUsuario").val("");
				oTabla.fnReloadAjax();
			}
		});
		
		$("#btnBuscarMias").click(function(){
			$("#hdnIdUsuario").val($("#hdnIdUsuarioAux").val());
			oTabla.fnReloadAjax();
		});

		$("#btnLimpiar").click(function() {
			$("#txtCodigoSolicitud").val("");
			$("#txtNombreSolicitud").val("");
			$("#txtFechaInicioDesde").val("");
			$("#txtFechaInicioHasta").val("");
			$("#ddlProyecto").val("");
			$("#ddlEstadoSolicitud").val("");
			$("#ddlDestacado").val("");
			$("#ddlPrioridad").val("");
			$("#ddlDestacado").val("");
			$("#ddlCategoria").val("");
			$("#ddlUsuario").val("");
			$("#ddlCliente").val("");
			$('.selectpicker').selectpicker('deselectAll');
			oTabla.fnReloadAjax();
		});

	});

	function ValidarFiltros() {
		var errores = [];

		var txtCodigoSolicitud = $("#txtCodigoSolicitud").val();
		if (txtCodigoSolicitud != "") {
			if (!ValidaNumerico(txtCodigoSolicitud)) {
				errores.push(" - El código es inválido.");
			}
		}

		var txtNombreSolicitud = $("#txtNombreSolicitud").val();
		if (txtNombreSolicitud != "") {
			if (!ValidaTexto(txtNombreSolicitud, 100)) {
				errores.push(" - El nombre es inválido.");
			}
		}

		if (errores.length > 0) {
			MostrarError("Datos incorrectos, ingrese nuevamente lo siguiente:", errores);
			return false;
		} else {
			return true;
		}
	}

	function ModificarSolicitud(Id) {
	    
	    $().redirect('asigna_solicitudes.php', {'idSolicitud': Id});
	}

	function NoDestacarSolicitud(Id) {
		var opcion = $("#fila" + Id).val();

		if (opcion != "0") {
			MarcarSolicitud(Id, 0);
			$("#fila" + Id).removeClass("icon-star").addClass("icon-star-empty");
			$("#fila" + Id).val("0");
		} else {
			MarcarSolicitud(Id, 1);
			$("#fila" + Id).removeClass("icon-star-empty").addClass("icon-star");
			$("#fila" + Id).val("1");
		}
	}

	function DestacarSolicitud(Id) {
		var opcion = $("#fila" + Id).val();

		if (opcion == "1") {
			MarcarSolicitud(Id, 0);
			$("#fila" + Id).removeClass("icon-star").addClass("icon-star-empty");
			$("#fila" + Id).val("0");
		} else {
			MarcarSolicitud(Id, 1);
			$("#fila" + Id).removeClass("icon-star-empty").addClass("icon-star");
			$("#fila" + Id).val("1");
		}
	}

	function MarcarSolicitud(Id, marca) {
		$.post("./BO/MarcarSolicitud.php", {
			idProyecto : Id,
			marca : marca
		});
	}
</script>

<!--  -->
<fieldset>
	<legend>
		Filtros de Búsqueda
	</legend>

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
			<label>Código Solicitud</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_NUMERO; ?>" class="input-xlarge" id="txtCodigoSolicitud" name="txtCodigoSolicitud">
			<label>Nombre Solicitud</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreSolicitud" name="txtNombreSolicitud">
		</div>
		<div class="span5">
			<?php
			$obj = new Utilidades($V_HOST, $V_USER, $V_PASS, $V_BBDD);
			echo $obj->GeneraSelectProyectos("ddlProyecto", true, true, 5);
			echo $obj->GeneraSelectEstadoSolicitud("ddlEstadoSolicitud", true, true, 5);
			?>
		</div>
		<div class="span1"></div>
	</div>
	<div class="row-fluid filtroAvanzado">
		<div class="span1"></div>
		<div class="span5">
			<?php
			echo $obj->GeneraSelectDestacado("ddlDestacado");
			echo $obj->GeneraSelectPrioridad("ddlPrioridad", true, true, 5);
			?>
			<label>Fecha de creación desde</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioDesde" name="txtFechaInicioDesde">
			<label>Fecha de creación hasta</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicioHasta" name="txtFechaInicioHasta">
		</div>
		<div class="span5">
			<?php
			echo $obj->GeneraSelectCategoriaSolicitud("ddlCategoria", true, true, 5);
			echo $obj->GeneraSelectUsuarios("ddlUsuario", true, true, 5);
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
			<button type="button" class="btn btn-lg btn-success" id="btnBuscarMias">
				Mis solicitudes
			</button>
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
						<th>Dest.</th>
						<th>Código</th>
						<th>Nombre</th>
						<th>Estado</th>
						<th>Proyecto</th>
						<th>Cliente</th>
						<th>Categoría</th>
						<th>Prioridad</th>
						<th>Usuario asignado</th>
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

<!-- Hiddens -->
<div style="display: none;">
	<input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" />
	<input type="hidden" id="hdnIdUsuarioAux" name="hdnIdUsuarioAux" />
</div>

<?php

include ("footer.php");
?>

