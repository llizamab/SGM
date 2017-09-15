<?php

include ("cabecera.php");
include ("menu.php");

$usu_id = $_SESSION["id_usuario"];
$Usuario = array();

$idUsuario = $_POST["idUsuario"];

if ($idUsuario == NULL || $usu_id == NULL || strlen($idUsuario) < 1) {
	echo $V_ACCES_DENIED;
	exit();
}

$query = "SELECT usu_id, 
                 usu_nombre,
                 usu_apellido,
                 usu_telefono,
                 usu_direccion,
                 usu_rut,
                 usu_correo
         FROM tsg_usuario
         WHERE usu_id = $idUsuario AND usu_activo = 1 ";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
$mySqli->query("SET NAMES 'utf8'");
$mySqli->query("SET CHARACTER SET 'utf8'");
$res = $mySqli -> query($query);

if ($mySqli -> affected_rows > 0)
{
    while ($row = $res -> fetch_assoc()) {
        $Usuario["usu_id"] = $row['usu_id'];
        $Usuario["usu_nombre"] = $row['usu_nombre'];
        $Usuario["usu_apellido"] = $row['usu_apellido'];
        $Usuario["usu_telefono"] = $row['usu_telefono'];
        $Usuario["usu_direccion"] = $row['usu_direccion'];
        $Usuario["usu_rut"] = $row["usu_rut"];
        $Usuario["usu_correo"] = $row["usu_correo"];
    }
    $mySqli -> close();
}

?>
<script type="text/javascript">

function cargarCampos()
{
    var id = "<?php echo $Usuario["usu_id"] ?>";
    var usu_nombre = "<?php echo $Usuario["usu_nombre"] ?>";
    var usu_apellido = "<?php echo $Usuario["usu_apellido"] ?>";
    var usu_telefono = "<?php echo $Usuario["usu_telefono"] ?>";
    var usu_direccion = "<?php echo $Usuario["usu_direccion"] ?>";
    var usu_rut = "<?php echo $Usuario["usu_rut"] ?>";
    var usu_direccion = "<?php echo $Usuario["usu_direccion"] ?>";
    var usu_correo = "<?php echo $Usuario["usu_correo"] ?>";
    
    $("#txtNombreUsuario").val(usu_nombre);
    $("#txtApellido").val(usu_apellido);
    $("#txtDireccion").val(usu_direccion);
    $("#txtTelefono").val(usu_telefono);
    $("#txtNombreRut").val(usu_rut);
    $("#txtCorreo").val(usu_correo);
    $("#hdnIdUsuario").val(id);
}

$(function() {
    
    $("#collapse<?php echo "3"; ?>").collapse('show');
    $("#busqueda_usuario").addClass("btn-info");
    
    cargarCampos();
    
    $("#btnVolver").click(function(){
        Ir("busqueda_usuario.php");
    });
    
    $("#btnEliminar").click(function(){
        bootbox.dialog({
          message: "¿Seguro que desea eliminar el usuario?",
          title: null,
          buttons: {
            Si: {
              label: "Si",
              className: "btn-success",
              callback: function() {
                    $.post("./BO/EliminarUsuario.php", {IdUsuario : $('#hdnIdUsuario').val()},
                        function(data) {
                            var obj = jQuery.parseJSON(data);
                            
                            var msj = obj.html;
                            var sub_msj = obj.errores; 
                            
                            var estado =  obj.estado;
                            if(estado == 'OK') // Exito
                            {
                                bootbox.alert(msj, function() {
                                  Ir("busqueda_usuario.php");
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
                  message: "¿Seguro que desea modificar el usuario?",
                  title: null,
                  buttons: {
                    Si: {
                      label: "Si",
                      className: "btn-success",
                      callback: function() {
                            $.post("./BO/ModificarsUsuario.php", $('#FormPrincipal').serialize(),
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
    
    $("#btnPerfiles").click(function(){
    	var IdUsuario = "<?php echo $idUsuario; ?>";
    	$().redirect('asignar_perfiles.php', {'IdUsuario': IdUsuario});
    });
});

function ValidarDatos(){
  var errores = [];
  
  var txtNombreUsuario = $("#txtNombreUsuario").val();
      
  if(!ValidaTexto(txtNombreUsuario,100)){
    errores.push(" - El nombre es inválido.");
  }
  
  var txtApellido = $("#txtApellido").val();
  
  if(!ValidaTexto(txtApellido,100)){
    errores.push(" - El apellido es inválido.");
  }
  
  var txtDireccion = $("#txtDireccion").val();
  
  if(!ValidaTexto(txtDireccion,100)){
    errores.push(" - La dirección es inválida.");
  }
  
  var txtTelefono = $("#txtTelefono").val();
  
  if(!ValidaNumerico(txtTelefono)){
    errores.push(" - El número de telefóno es inválido.");
  }
  else{
      if(txtTelefono.length < 8){
          errores.push(" - El número de teléfono es inválido.");
      }
  }
  
  var txtPass = $("#txtPass").val();
  
  if(txtPass != ""){
      var passV = $("#txtPassConfirmar").val();
    
      if (!validaFormatoPass(txtPass) || !validaFormatoPass(passV) || (txtPass != passV)) {
        errores.push(" - Contraseña invalida, o no coinciden");
      } 
  }
  

  
  var txtCorreo = $("#txtCorreo").val();
  
  if(!ValidaCorreo(txtCorreo)){
    errores.push(" - El correo es inválido.");
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
</script>
<!--  -->
<fieldset>
    <legend>Modificar Usuario</legend>
    
    <div id="divErrores" style="width: 60%;"></div>
    
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <label>
            <div>
                Nombre(s) Usuario <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreUsuario" name="txtNombreUsuario">

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
        
        <label>
            <div>
                Telefóno <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_NUMERO; ?>" class="input-xlarge" id="txtTelefono" name="txtTelefono">
          
    </div>
    <div class="span5">
        <label>
            <div>
                Rut <small class="text-error req"></small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_RUT; ?>" class="input-xlarge" id="txtNombreRut" name="txtNombreRut" disabled >

        <label>
            <div>
                Contraseña <small class="text-error req"></small>
            </div></label>
        <input type="password" placeholder="<?php echo $V_MSG_PH_PASS; ?>" class="input-xlarge" id="txtPass" name="txtPass">
        
        <label>
            <div>
                Confirmar Contraseña <small class="text-error req">*</small>
            </div></label>
        <input type="password" placeholder="<?php echo $V_MSG_PH_PASS; ?>" class="input-xlarge" id="txtPassConfirmar" name="txtPassConfirmar">
            
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
        	<button type="button" class="btn btn-lg btn-success" id="btnPerfiles">
				Asignar Perfiles
			</button>
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

<div>
    &nbsp;
</div>
<div>
    &nbsp;
</div>

<div style="display: none;">
    <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" />
</div>

<?php

include ("footer.php");
?>






