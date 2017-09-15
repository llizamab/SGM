<?php

require("cabecera.php");
include("menu.php");

$usuario = array();

$usu_id = $_SESSION["id_usuario"];

$query = "SELECT `usu_nombre`, 
				 `usu_apellido`, `usu_telefono`, 
				 `usu_direccion`, `usu_correo`, `usu_rut`
		  FROM `tsg_usuario` 
		  WHERE `usu_id` = '$usu_id' AND `usu_activo` = 1";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
$res = $mySqli->query($query);
		

if($mySqli->affected_rows > 0) // Si los datos son validos
{
	while($row = $res->fetch_assoc())
	{
		$usuario["usu_nombre"] = $row['usu_nombre'];
		$usuario["usu_apellido"] = $row['usu_apellido'];
		$usuario["usu_telefono"] = $row['usu_telefono'];
		$usuario["usu_direccion"] = $row['usu_direccion'];
		$usuario["usu_correo"] = $row['usu_correo'];
		$usuario["rut"] = $row["usu_rut"];
	}
	$mySqli->close();
}

?>

<script type="text/javascript">

	function ValidarDatos()
	{
	  var errores = [];
	  var nombre = $("#txtNombre").val();
	  
	  if(!ValidaTexto(nombre, 100)){
	  	errores.push(" - El nombre es inválido.");
	  }
	  var apellido = $("#txtApellido").val();
	  
	  if(!ValidaTexto(apellido, 100)){
	  	errores.push(" - El apellido es inválido.");
	  }
	  
	  var telefono = $("#txtTelefono").val();
	  
	  if(!ValidaNumerico(telefono)){
	  	errores.push(" - El número de teléfono es inválido.");
	  }
	  else{
	      if(telefono.length < 8){
	          errores.push(" - El número de teléfono es inválido.");
	      }
	  }
	  
	  var direccion = $("#txtDireccion").val();
	  
	  if(direccion != ""){ // Opcional
	  	if(!ValidaTexto(direccion, 100)){
		  	errores.push(" - La dirección es inválida.");
		  }
	  }
	  
	  var correo = $("#txtCorreo").val();
	  
	  if(!ValidaCorreo(correo)){
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

	$(function() {

		$(".alert").alert();

		$("#btnGuardar").click(function() {
			
			if(ValidarDatos())
			{
			    bootbox.dialog({
                  message: "¿Está seguro de modificar sus datos?",
                  title: null,
                  buttons: {
                    Si: {
                      label: "Si",
                      className: "btn-success",
                      callback: function() {
                            $.post("./BO/ModificarDatosUsuario.php", $('#FormPrincipal').serialize(),
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

		$("#btnCambiaPass").click(function() {
			
			var passA = $("#txtPassActual").val();
			var passN = $("#txtPassNueva").val();
			var passV = $("#txtPassConfirmar").val();
			
			// Validaciones de datos
			if (!validaFormatoPass(passA) || !validaFormatoPass(passN) || !validaFormatoPass(passV) || (passN != passV)) {
				// mostrar error
				var errs = ["- Longitud máxima 20 caracteres", "- Longitud minima 4 caracteres", "- Alfa-numerica"];
				MostrarError("Contraseña invalida, o no coinciden", errs);
				$("#txtPassNueva").val("");
				$("#txtPassConfirmar").val("");
				$("#txtPassActual").val("");
			} 
			else // Enviar post al servidor 
			{
				$.post("./BO/CambiarPass.php", $('#FormPrincipal').serialize(),
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
		});

	});
	
	var flag1 = true;
    
    function OcultaPass()
    {
        if(flag1 == true)
        {
            $("#btnOcultaPass").removeClass( "icon-chevron-down" ).addClass( "icon-chevron-up" );
            $(".filtroAvanzado").show();
            flag1 = false;
        }   
        else
        {
            $("#btnOcultaPass").removeClass( "icon-chevron-up" ).addClass( "icon-chevron-down" );
            $(".filtroAvanzado").hide();
            flag1 = true;
        }
    }

</script>

<!-- Contenido -->
<fieldset>
	<legend>
		Mi Información Personal
	</legend>

	<div id="divErrores" style="width: 60%;"></div>
	
	<div class="row-fluid">
		<div class="span9"></div>
		<div class="span2">
			<div>Cambiar Contraseña</div>
		</div>
		<div class="span1">
			<a class="btn btn-info" href="javascript:OcultaPass();"><i id="btnOcultaPass" class="icon-chevron-down"></i></a>
		</div>
	</div>
		
	<div class="row-fluid">
		<div class="span1"></div>
		<div class="span5">
			<label>Rut</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_RUT; ?>" class="input-xlarge disabled" value="<?php echo $usuario["rut"]; ?>" name="rut" disabled >
			<label><div>Nombre(s) <small class="text-error req">*</small></div></label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombre" value="<?php echo $usuario["usu_nombre"]; ?>" name="txtNombre">
			<label><div>Apellido(s) <small class="text-error req">*</small></div></label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtApellido" value="<?php echo $usuario["usu_apellido"]; ?>" name="txtApellido" >
		</div>
		<div class="span5">
			<label><div>Teléfono <small class="text-error req">*</small></div></label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_NUMERO; ?>" class="input-xlarge" id="txtTelefono" value="<?php echo $usuario["usu_telefono"]; ?>" name="txtTelefono">
			<label>Dirección</label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtDireccion" value="<?php echo $usuario["usu_direccion"]; ?>" name="txtDireccion" >
			<label><div>Correo <small class="text-error req">*</small></div></label>
			<input type="text" placeholder="<?php echo $V_MSG_PH_MAIL; ?>" class="input-xlarge" id="txtCorreo" value="<?php echo $usuario["usu_correo"]; ?>" name="txtCorreo">
		</div>
		<div class="span1"></div>
	</div>
	
	<div>
		&nbsp;
	</div>
	
	<div class="row-fluid pagination-centered">
		<div class="span4"></div>
		<div class="span1">
			<button type="button" class="btn btn-lg btn-primary" id="btnGuardar">
				Guardar
			</button>
		</div>
		
		<div class="span7"></div>	
	</div>
	
	<div>
		&nbsp;
	</div>
	
	<div class="row-fluid filtroAvanzado">
		<div class="span1"></div>
		<div class="span5">
			<label><div>Contraseña Actual <small class="text-error req">*</small></div></label>
			<input type="password" placeholder="<?php echo $V_MSG_PH_PASS; ?>" class="input-xlarge" id="txtPassActual" name="txtPassActual">
			<label><div>Nueva Contraseña <small class="text-error req">*</small></div></label>
			<input type="password" placeholder="<?php echo $V_MSG_PH_PASS; ?>" class="input-xlarge" id="txtPassNueva" name="txtPassNueva">
			<label><div>Confirmar Contraseña <small class="text-error req">*</small></div></label>
			<input type="password" placeholder="<?php echo $V_MSG_PH_PASS; ?>" class="input-xlarge" id="txtPassConfirmar" name="txtPassConfirmar">
			<button type="button" class="btn btn-lg btn-primary" id="btnCambiaPass">
				Cambiar Contraseña
			</button>
		</div>
		<div class="span5">
		</div>
		<div class="span1"></div>
	</div>
</fieldset>

<div>
	&nbsp;
</div>
<div>
	&nbsp;
</div>

<?php

include ("footer.php");
?>