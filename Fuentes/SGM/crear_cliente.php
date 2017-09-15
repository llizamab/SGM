<?php

include("cabecera.php");
include("menu.php");

if(!ValidaAcceso("crear_cliente.php", $_SESSION["paginas"]))
{
    echo $V_ACCES_DENIED;
    exit();
}

?>
<script type="text/javascript">
var validoRut = false;

$(function() {
    
    $("#collapse<?php echo "2"; ?>").collapse('show');
    $("#crear_cliente").addClass("btn-info");
    
    $("#btnGuardar").click(function(){
        if(ValidarDatos()){
            
            bootbox.dialog({
              message: "¿Seguro que desea registrar el cliente?",
              title: null,
              buttons: {
                Si: {
                  label: "Si",
                  className: "btn-success",
                  callback: function() {
                        $.post("./BO/CrearCliente.php", $('#FormPrincipal').serialize(),
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

function Limpiar(){
    $("#txtCorreo").val("");
    $("#txtRut").val("");
    $("#txtDireccion").val("");
    $("#txtApellido").val("");
    $("#txtNombreCliente").val("");
    $("#txtNombreEmpresa").val("");
    validoRut = false;
}

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
</script>
<!--  -->
<fieldset>
    <legend>Registrar Cliente</legend>
    
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
                Registrar Cliente
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






