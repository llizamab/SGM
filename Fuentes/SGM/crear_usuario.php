<?php

include("cabecera.php");
include("menu.php");

if(!ValidaAcceso("crear_usuario.php", $_SESSION["paginas"]))
{
    echo $V_ACCES_DENIED;
    exit();
}

?>
<script type="text/javascript">
var validoRut = false;

$(function() {
    
    $("#collapse<?php echo "3"; ?>").collapse('show');
    $("#crear_usuario").addClass("btn-info");
        
    $("#btnGuardar").click(function(){
        if(ValidarDatos()){
            
            bootbox.dialog({
              message: "¿Seguro que desea registrar el usuario?",
              title: null,
              buttons: {
                Si: {
                  label: "Si",
                  className: "btn-success",
                  callback: function() {
                        $.post("./BO/CrearUsuario.php", $('#FormPrincipal').serialize(),
                            function(data) {
                                var obj = jQuery.parseJSON(data);
                                
                                var msj = obj.html;
                                var sub_msj = obj.errores; 
                                
                                var estado =  obj.estado;
                                if(estado == 'OK') // Exito
                                {
                                    MostrarExito(msj, sub_msj);
                                    Limpiar();
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
    
    $("#btnLimpiar").click(function(){
        Limpiar();
    });
    
    $('#txtNombreRut').Rut({
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

function Limpiar(){
    $("#txtNombreUsuario").val("");
    $("#txtApellido").val("");
    $("#txtDireccion").val("");
    $("#txtTelefono").val("");
    $("#txtNombreRut").val("");
    $("#txtPass").val("");
    $("#txtCorreo").val("");
    $("#txtPassConfirmar").val("");
    validoRut = false;
}

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

      if(!validoRut){
        errores.push(" - El rut es inválido.");
      }
      
      var txtPass = $("#txtPass").val();
      
      if(!validaFormatoPass(txtPass)){
        errores.push(" - La contraseña es inválida.");
      }
      
      var passA = $("#txtPass").val();
      var passV = $("#txtPassConfirmar").val();
        
      if (!validaFormatoPass(passA) || !validaFormatoPass(passV) || (passA != passV)) {
        errores.push(" - Contraseña invalida, o no coinciden");
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
    <legend>Registrar Usuario</legend>
    
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
                Rut <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_RUT; ?>" class="input-xlarge" id="txtNombreRut" name="txtNombreRut">

        <label>
            <div>
                Contraseña <small class="text-error req">*</small>
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
            <button type="button" class="btn btn-lg btn-primary" id="btnGuardar">
                Registrar Usuario
            </button>
            <button type="button" class="btn btn-lg btn-primary" id="btnLimpiar">
                Limpiar
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

<?php

include ("footer.php");
?>






