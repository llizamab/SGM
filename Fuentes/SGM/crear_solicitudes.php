<?php

include("cabecera.php");
include("menu.php");

if(!ValidaAcceso("crear_solicitudes.php", $_SESSION["paginas"]))
{
    echo $V_ACCES_DENIED;
    exit();
}

?>
<script type="text/javascript">

$(function() {
    
    $("#collapse<?php echo "4"; ?>").collapse('show');
    $("#crear_solicitudes").addClass("btn-info");
    
    $("#btnGuardar").click(function(){
        if(ValidarDatos()){

            bootbox.dialog({
              message: "¿Seguro que desea registrar la solicitud?",
              title: null,
              buttons: {
                Si: {
                  label: "Si",
                  className: "btn-success",
                  callback: function() {
                        $.post("./BO/CrearSolicitud.php", $('#FormPrincipal').serialize(),
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
    
});

function Limpiar(){
    $("#txtNombre").val("");
    $("#txtDescripcion").val("");
    $("#txtCorreoCopia").val("");
    $('.selectpicker').selectpicker('deselectAll');
}

function ValidarDatos(){
      var errores = [];
      var nombre = $("#txtNombre").val();
      
      if(!ValidaTexto(nombre, 100)){
        errores.push(" - El nombre es inválido.");
      }
      var Descripcion = $("#txtDescripcion").val();
      
      if(!ValidaTexto(Descripcion, 1000)){
        errores.push(" - La descripción es inválida.");
      }
      
      var txtCorreoCopia = $("#txtCorreoCopia").val();
      
      if(txtCorreoCopia != ""){
          
          var correos = txtCorreoCopia.split(';');
          if(correos == null){
              errores.push(" - Correos en copia inválido.");
          }
          else
          {
              correos.forEach(function(entry) {
                  if(entry != ""){
                       if(!ValidaCorreo(entry)){
                           errores.push(" - correo "+ entry +" inválido.");
                       }
                  }
              });
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
</script>
<!--  -->
<fieldset>
    <legend>Registrar Solicitud</legend>
    
    <div id="divErrores" style="width: 60%;"></div>
    
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <label>
            <div>
                Nombre <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombre" name="txtNombre" >

        <?php
        $obj = new Utilidades($V_HOST, $V_USER, $V_PASS, $V_BBDD);
        echo $obj->GeneraSelectProyectos("ddlProyecto", false, true, 5);
        ?>

        <label>
            <div>
                Descripción <small class="text-error req">*</small>
            </div></label>
        <textarea rows="3" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtDescripcion" name="txtDescripcion"></textarea>
          
    </div>
    <div class="span5">

        <?php
        echo $obj->GeneraSelectPrioridad("ddlPrioridad", false, true, 5);
        echo $obj->GeneraSelectCategoriaSolicitud("ddlCategoria", false, true, 5);
        ?>

        <label>
            <div>
                Correo(s) en copia <small class="text-error req">(Separar correos con un <b>;</b> )</small>
            </div></label>
        <textarea rows="3" placeholder="<?php echo $V_MSG_PH_MAIL; ?>" class="input-xlarge" id="txtCorreoCopia" name="txtCorreoCopia" ></textarea>
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
                Registrar Solicitud
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


