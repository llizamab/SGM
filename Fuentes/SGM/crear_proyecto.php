<?php

include("cabecera.php");
include("menu.php");

if(!ValidaAcceso("crear_proyecto.php", $_SESSION["paginas"]))
{
    echo $V_ACCES_DENIED;
    exit();
}

?>
<script type="text/javascript">

$(function() {
    
    $("#collapse<?php echo "1"; ?>").collapse('show');
    $("#crear_proyecto").addClass("btn-info");
    
    $("#btnGuardar").click(function(){
        if(ValidarDatos()){
            
            bootbox.dialog({
              message: "¿Seguro que desea registrar el proyecto?",
              title: null,
              buttons: {
                Si: {
                  label: "Si",
                  className: "btn-success",
                  callback: function() {
                    $.post("./BO/CrearProyecto.php", $('#FormPrincipal').serialize(),
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
    $("#txtNombreProyecto").val("");
    $("#txtDuracion").val("");
    $("#hdnDuracion").val("");
    $("#txtDescripcion").val("");
    $("#txtFechaInicio").val("");
    $("#txtFechaTermino").val("");
    $("#txtFechaGarantia").val("");
    $('.selectpicker').selectpicker('deselectAll');
}

function ValidarDatos(){
      var errores = [];
      
      var encargados = $("#ddlJefeProyecto").val(); 
      
      if(encargados == "" || encargados == null){
        errores.push(" - Debe especificar al menos un encargado.");
      }
      
      var nombre = $("#txtNombreProyecto").val();
      
      if(!ValidaTexto(nombre,100)){
        errores.push(" - El nombre es inválido.");
      }
      var duracion = $("#txtDuracion").val();
      
      if(!ValidaTexto(duracion, 100)){
        errores.push(" - La duración es inválida.");
      }
      
      var descripcion = $("#txtDescripcion").val();
      
      if(descripcion != ""){
          if(!ValidaTexto(descripcion,255)){
            errores.push(" - La descripción es inválida.");
          }
      }
      
      var txtFechaInicio = $("#txtFechaInicio").val();
      
      if(!ValidaFecha(txtFechaInicio)){
        errores.push(" - La fecha de inicio es inválida.");
      }
      
      var txtFechaTermino = $("#txtFechaTermino").val();
      
      if(!ValidaFecha(txtFechaTermino)){
        errores.push(" - La fecha de termino es inválida.");
      }
      
      var txtFechaGarantia = $("#txtFechaGarantia").val();
      
      if(!ValidaFecha(txtFechaGarantia)){
        errores.push(" - La fecha de garantía es inválida.");
      }
      
      if(ValidaFecha(txtFechaInicio) && ValidaFecha(txtFechaTermino) && !ValidaFechaDiff(txtFechaInicio, txtFechaTermino)){
        errores.push(" - La fecha de termino debe ser mayor a la de inicio.");
      }
      
      if(ValidaFecha(txtFechaGarantia) && ValidaFecha(txtFechaTermino) && !ValidaFechaDiff(txtFechaTermino, txtFechaGarantia)){
        errores.push(" - La fecha de garantía debe ser mayor a la de termino.");
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
    
    function CalcularDuracion()
    {
        var txtFechaInicio = $("#txtFechaInicio").val();
        var txtFechaGarantia = $("#txtFechaGarantia").val();
        
        if(ValidaFecha(txtFechaInicio) && ValidaFecha(txtFechaGarantia) && ValidaFechaDiff(txtFechaInicio, txtFechaGarantia))
        {
            var minutes = 1000 * 60;
            var hours   = minutes * 60;
            var days    = hours * 24;
            var years   = days * 365;
            var x = txtFechaInicio.split("-");
            txtFechaInicio = x[1] + "/" + x[0] + "/" + x[2];
            var d1 = new Date(txtFechaInicio);
            x = txtFechaGarantia.split("-");
            txtFechaGarantia = x[1] + "/" + x[0] + "/" + x[2];
            var d2 = new Date(txtFechaGarantia);
            var dif = d2.getTime() - d1.getTime();
            
            var difYears = Math.round(dif/years);
            var num_months = (dif % 31536000000)/2628000000;
            var num_days = ((dif % 31536000000) % 2628000000)/86400000;
            
            var duracion = Math.round(difYears) + " año(s), " + Math.round(num_months) + " mes(es) " + Math.round(num_days) + " día(s)";
            
            $("#txtDuracion").val(duracion);
            $("#hdnDuracion").val(duracion);
        }
    }
    
    function monthDiff(d1, d2) {
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth() + 1;
        months += d2.getMonth();
        return months <= 0 ? 0 : months;
    }
</script>
<!--  -->
<fieldset>
    <legend>Registrar Proyecto</legend>
    
    <div id="divErrores" style="width: 70%;"></div>
    
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <label>
            <div>
                Nombre Proyecto <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombreProyecto" name="txtNombreProyecto">

        <label>
            <div>
                Duración garantía <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="" class="input-xlarge" id="txtDuracion" name="txtDuracion" disabled>
        <?php
        $obj = new Utilidades($V_HOST, $V_USER, $V_PASS, $V_BBDD);

        echo $obj->GeneraSelectEncargado("ddlJefeProyecto", true, true, 5);
        
        echo $obj->GeneraSelectClientes("ddlCliente", false, true, 5);
        ?>

        <label>Descripción</label>
        <textarea rows="3" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtDescripcion" name="txtDescripcion"></textarea>
          
    </div>
    <div class="span5">
        <label><div>Fecha de inicio <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaInicio" name="txtFechaInicio" onchange="CalcularDuracion();">
        <label><div>Fecha de término <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaTermino" name="txtFechaTermino" >
        <label><div>Fecha de garantía <small class="text-error req">*</small>
            </div></label>
        <input type="text" placeholder="<?php echo $V_MSG_PH_FECHA; ?>" class="txtFecha" id="txtFechaGarantia" name="txtFechaGarantia" onchange="CalcularDuracion();">

        <?php
        echo $obj -> GeneraSelectTipoProyecto("ddlTipoProyecto", false, true, 5);
        echo $obj -> GeneraSelectEstadoProyecto("ddlEstadoProyecto", false, true, 5);
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
            <button type="button" class="btn btn-lg btn-primary" id="btnGuardar">
                Registrar Proyecto
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

<div style="display: none;">
    <input type="hidden" id="hdnDuracion" name="hdnDuracion" />
</div>

<?php

include ("footer.php");
?>


