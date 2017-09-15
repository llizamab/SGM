<?php
include("cabecera.php");
include("menu.php");

$usu_id = $_SESSION["id_usuario"];
$cliente = array();

$idCliente = $_POST["idCliente"];

if ($idCliente == NULL || $usu_id == NULL || strlen($idCliente) < 1) {
	echo $V_ACCES_DENIED;
	exit();
}

$query = "SELECT pry.cli_id, 
				 pry.cli_nombre,
				 pry.cli_apellido,
				 pry.cli_correo,
				 pry.cli_empresa,
				 pry.cli_rut,
		    	 pry.cli_direccion
				 
		 FROM tsg_cliente pry
		 WHERE pry.cli_id = $idCliente AND pry.cli_activo = 1 ";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
$mySqli->query("SET NAMES 'utf8'");
$mySqli->query("SET CHARACTER SET 'utf8'");
$res = $mySqli -> query($query);

if ($mySqli -> affected_rows > 0)
{
	while ($row = $res -> fetch_assoc()) {
		$cliente["cli_id"] = $row['cli_id'];
		$cliente["cli_nombre"] = $row['cli_nombre'];
		$cliente["cli_apellido"] = $row['cli_apellido'];
		$cliente["cli_correo"] = $row['cli_correo'];
		$cliente["cli_empresa"] = $row["cli_empresa"];
		$cliente["cli_rut"] = $row["cli_rut"];
		$cliente["cli_direccion"] = $row["cli_direccion"];
		}
	$mySqli -> close();
}

?>
<script type="text/javascript">

function cargarCampos()
{
    var cli_id = "<?php echo $cliente["cli_id"] ?>";
    var cli_nombre = "<?php echo $cliente["cli_nombre"] ?>";
    var cli_apellido = "<?php echo $cliente["cli_apellido"] ?>";
    var cli_correo = "<?php echo $cliente["cli_correo"] ?>";
    var cli_empresa = "<?php echo $cliente["cli_empresa"] ?>";
    var cli_rut = "<?php echo $cliente["cli_rut"] ?>";
    var cli_direccion = "<?php echo $cliente["cli_direccion"] ?>";
    
    $("#txtNombreEmpresa").val(cli_empresa);
    $("#txtNombreCliente").val(cli_nombre);
    $("#txtApellido").val(cli_apellido);
    $("#txtDireccion").val(cli_direccion);
    $("#txtRut").val(cli_rut);
    $("#txtCorreo").val(cli_correo);
    $("#hdnIdCliente").val(cli_id);
}

var validoRut = false;

$(function() {
    cargarCampos();
    
    $("#collapse<?php echo "2"; ?>").collapse('show');
    $("#busqueda_cliente").addClass("btn-info");
    
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
                    "data" : {ddlCliente:[$("#hdnIdCliente").val()]},
                    "success" : fnCallback
                });
            }
        });
    
    $("#btnVolver").click(function(){
        Ir("busqueda_cliente.php");
    });
    
    $("#btnEliminar").click(function(){
        bootbox.dialog({
          message: "¿Seguro que desea eliminar el cliente?",
          title: null,
          buttons: {
            Si: {
              label: "Si",
              className: "btn-success",
              callback: function() {
                    $.post("./BO/EliminarCliente.php", {IdCliente : $('#hdnIdCliente').val()},
                        function(data) {
                            var obj = jQuery.parseJSON(data);
                            
                            var msj = obj.html;
                            var sub_msj = obj.errores; 
                            
                            var estado =  obj.estado;
                            if(estado == 'OK') // Exito
                            {
                                bootbox.alert(msj, function() {
                                  Ir("busqueda_cliente.php");
                                });
                            }
                            else // Error
                            {
                                MostrarError(msj, sub_msj);
                            }
                    });
                }
            },
            No: {
              label: "No",
              className: "btn-info",
              callback: function() {
                
              }
            }
          }
        });
    });
    
    $("#btnGuardar").click(function(){
        if(ValidarDatos()){
            
            bootbox.dialog({
                  message: "¿Seguro que desea modificar el cliente?",
                  title: null,
                  buttons: {
                    Si: {
                      label: "Si",
                      className: "btn-success",
                      callback: function() {
                            $.post("./BO/ModificarDatosCliente.php", $('#FormPrincipal').serialize(),
                                function(data) {
                                    var obj = jQuery.parseJSON(data);
                                    
                                    var msj = obj.html;
                                    var sub_msj = obj.errores; 
                                    
                                    var estado =  obj.estado;
                                    if(estado == 'OK') // Exito
                                    {
                                        MostrarExito(msj, sub_msj);
                                    }
                                    else // Error
                                    {
                                        MostrarError(msj, sub_msj);
                                    }
                            });
                        }
                    },
                    No: {
                      label: "No",
                      className: "btn-info",
                      callback: function() {
                        
                      }
                    }
                  }
                });
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
    });

    function ValidarDatos(){
      var errores = [];
  
	  var txtNombreEmpresa = $("#txtNombreEmpresa").val();
	  
	  if(!ValidaTexto(txtNombreEmpresa,100)){
	  	errores.push(" - El Nombre empresa es inválido.");
	  }
	  
	  var txtNombreCliente = $("#txtNombreCliente").val();
	  
	  if(!ValidaTexto(txtNombreCliente,100)){
	  	errores.push(" - El Nombre es inválido.");
	  }
	  
	  var txtApellido = $("#txtApellido").val();
	  
	  if(!ValidaTexto(txtApellido,100)){
	  	errores.push(" - El Apellido es inválido.");
	  }
	  
	  var txtDireccion = $("#txtDireccion").val();
      
      if(!ValidaTexto(txtDireccion,100)){
        errores.push(" - La Dirección es inválida.");
      }

      if(!validoRut){
        errores.push(" - El rut es inválido.");
      }
	  
	  var correo = $("#txtCorreo").val();
	  
  	  if(!ValidaCorreo(correo)){
	  	errores.push(" - El Correo es inválido.");
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
    
    function ModificarProyecto(idProyecto)
    {
        $().redirect('modificar_proyecto.php', {'idProyecto': idProyecto});
    }
</script>
<!--  -->
<fieldset>
    <legend>Modificar Cliente</legend>
    
    <div id="divErrores" style="width: 60%;"></div>
    
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <label>
            <div>
                Nombre(s) <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreCliente" name="txtNombreCliente">

        <label>
            <div>
                Apellido(s) <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtApellido" name="txtApellido">
        
        <label>
            <div>
                Dirección <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtDireccion" name="txtDireccion">
          
    </div>
    <div class="span5">
        <label>
            <div>
                Rut <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_RUT; ?>" class="input-xlarge" id="txtRut" name="txtRut">
        <label>
            <div>
                Nombre Empresa <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreEmpresa" name="txtNombreEmpresa">
        <label>
            <div>
                Correo <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_MAIL; ?>" class="input-xlarge" id="txtCorreo" name="txtCorreo">
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
			<button type="button" class="btn btn-lg btn-primary" id="btnGuardar">
				Guardar
			</button>
			<button type="button" class="btn btn-lg btn-primary" id="btnVolver">
				Volver
			</button>
			<button type="button" class="btn btn-lg btn-danger" id="btnEliminar">
				Eliminar
			</button>
        </p>
    </div>
</div>

<fieldset>
    <legend>
        Proyectos
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
<div style="display: none;">
    <input type="hidden" id="hdnIdCliente" name="hdnIdCliente" />
</div>

<?php

include ("footer.php");
?>
