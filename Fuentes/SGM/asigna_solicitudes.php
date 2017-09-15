<?php
require ("cabecera.php");
include ("menu.php");

$usu_id = $_SESSION["id_usuario"];
$Solicitud = array();

$idSolicitud = $_POST["idSolicitud"];

if ($idSolicitud == NULL || $usu_id == NULL || strlen($idSolicitud) < 1) {
    echo $V_ACCES_DENIED;
    exit();
}

$query = "SELECT DISTINCT 
                tick.tic_id,
                tick.tic_nombre,
                tick.tic_descripcion,
                tick.tsg_tic_correo_en_copia,
                tick.tsg_estado_ticketest_id,
                tick.tsg_proyectopro_id,
                tick.tsg_categoriacat_id,
                tick.tsg_prioridadpri_id,
                tick.tsg_usuariousu_id
          FROM tsg_ticket tick
          WHERE 
                tick.tic_id = $idSolicitud ";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
$mySqli->query("SET NAMES 'utf8'");
$mySqli->query("SET CHARACTER SET 'utf8'");
$res = $mySqli -> query($query);

if ($mySqli -> affected_rows > 0)
{
    while ($row = $res -> fetch_assoc()) {
        $Solicitud["tic_id"] = $row['tic_id'];
        $Solicitud["tic_nombre"] = $row['tic_nombre'];
        $Solicitud["tic_descripcion"] = $row['tic_descripcion'];
        $Solicitud["tsg_tic_correo_en_copia"] = $row['tsg_tic_correo_en_copia'];
        $Solicitud["tsg_estado_ticketest_id"] = $row['tsg_estado_ticketest_id'];
        $Solicitud["tsg_proyectopro_id"] = $row['tsg_proyectopro_id'];
        $Solicitud["tsg_categoriacat_id"] = $row['tsg_categoriacat_id'];
        $Solicitud["tsg_prioridadpri_id"] = $row["tsg_prioridadpri_id"];
        $Solicitud["tsg_usuariousu_id"] = $row["tsg_usuariousu_id"];
    }
    $mySqli -> close();
}

// determino si soy desarrollador
$roles = $_SESSION['roles'];
$soy_dev = false;

if(is_array($roles) && count($roles) == 1 && $roles[4] != ""){
    $soy_dev = true;
}

?>
<script type="text/javascript">

    var guardoObs = false;

    function cargarCampos()
    {
        var id = "<?php echo $Solicitud["tic_id"]; ?>";
        var idEstado = "<?php echo $Solicitud["tsg_estado_ticketest_id"]; ?>";
        var idProyecto = "<?php echo $Solicitud["tsg_proyectopro_id"]; ?>";
        var idCategoria = "<?php echo $Solicitud["tsg_categoriacat_id"]; ?>";
        var idPrioridad = "<?php echo $Solicitud["tsg_prioridadpri_id"]; ?>";
        var idUsuario = "<?php echo $Solicitud["tsg_usuariousu_id"]; ?>";
        
        var txtNombre = "<?php echo $Solicitud["tic_nombre"]; ?>";
        var txtDescripcion = "<?php echo $Solicitud["tic_descripcion"]; ?>";
        var txtCorreoCopia = "<?php echo $Solicitud["tsg_tic_correo_en_copia"]; ?>";
        
        $("#ddlEstado").selectpicker('val', idEstado);
        $("#ddlProyecto").selectpicker('val', idProyecto);
        $("#ddlCategoria").selectpicker('val', idCategoria);
        $("#ddlPrioridad").selectpicker('val', idPrioridad);
        $("#ddlUsuario").selectpicker('val', idUsuario);
        $("#hdnIdSolicitud").val(id);
        $("#txtCodigo").val(id);
        $("#txtNombre").val(txtNombre);
        $("#txtDescripcion").val(txtDescripcion);
        $("#txtCorreoCopia").val(txtCorreoCopia);

        $(".filtroAvanzado").hide();
        $(".filtroAvanzadoAgregaObs").hide();
        $(".filtroAvanzadoH").hide();
    }

    var oTabla;
    var flag1 = true;
    var flag2 = true;
    var flag3 = true;
    
    function OcultaObservaciones(){
        if(flag1 == true)
        {
            $("#btnOcultaObservaciones").removeClass( "icon-chevron-down" ).addClass( "icon-chevron-up" );
            $(".filtroAvanzado").show();
            flag1 = false;
        }   
        else
        {
            $("#btnOcultaObservaciones").removeClass( "icon-chevron-up" ).addClass( "icon-chevron-down" );
            $(".filtroAvanzado").hide();
            flag1 = true;
        }
    }
    
    function OcultaAgregaObs(){
       if(flag2 == true)
        {
            $("#btnOcultaAgregaObs").removeClass( "icon-chevron-down" ).addClass( "icon-chevron-up" );
            $(".filtroAvanzadoAgregaObs").show();
            flag2 = false;
        }   
        else
        {
            $("#btnOcultaAgregaObs").removeClass( "icon-chevron-up" ).addClass( "icon-chevron-down" );
            $(".filtroAvanzadoAgregaObs").hide();
            flag2 = true;
        } 
    }
    
    function OcultaHistorico(){
        if(flag3 == true)
        {
            $("#btnOcultaHistorico").removeClass( "icon-chevron-down" ).addClass( "icon-chevron-up" );
            $(".filtroAvanzadoH").show();
            flag3 = false;
        }   
        else
        {
            $("#btnOcultaHistorico").removeClass( "icon-chevron-up" ).addClass( "icon-chevron-down" );
            $(".filtroAvanzadoH").hide();
            flag3 = true;
        }
    }

    $(function() {
        
        $("#collapse<?php echo "4"; ?>").collapse('show');
        $("#busqueda_solicitudes").addClass("btn-info");
        
        cargarCampos();
        
        $("#btnVolver").click(function(){
            Ir("busqueda_solicitudes.php");
        });
        
        oTabla = $('#tblObservaciones').dataTable({
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
            "sAjaxSource" : './BO/BuscaObservacionesSolicitud.php', // fuente del json
            "fnServerData" : function(sSource, aoData, fnCallback) {// Para buscar con el boton
                $.ajax({
                    "dataType" : 'json',
                    "type" : "POST",
                    "url" : sSource,
                    "data" : {IdSolicitud : $('#hdnIdSolicitud').val()},
                    "success" : fnCallback
                });
            }
        });
        
        var oTablaH = $('#tblHistorico').dataTable({
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
            "sAjaxSource" : './BO/BuscaHistoricoSolicitud.php', // fuente del json
            "fnServerData" : function(sSource, aoData, fnCallback) {// Para buscar con el boton
                $.ajax({
                    "dataType" : 'json',
                    "type" : "POST",
                    "url" : sSource,
                    "data" : {IdSolicitud : $('#hdnIdSolicitud').val()},
                    "success" : fnCallback
                });
            }
        });
        
        $("#btnGuardar").click(function(){
            if(ValidarDatos()){
                $.post("./BO/ModificarDatosSolicitud.php", $('#FormPrincipal').serialize(),
                    function(data) {
                        var obj = jQuery.parseJSON(data);
                        
                        var msj = obj.html;
                        var sub_msj = obj.errores; 
                        
                        var estado =  obj.estado;
                        if(estado == 'OK') // Exito
                        {
                            MostrarExito(msj, sub_msj);
                            <?php
                            if($soy_dev == TRUE){
                            ?>
                                $("#btnGuardar").prop('disabled', true);
                                $("#btnGuardaObservacion").prop('disabled', true);
                            <?php
                            }
                            ?>
                            oTablaH.fnReloadAjax();
                        }
                        else // Error
                        {
                            MostrarError(msj, sub_msj);
                        }
                });
            }
        });
        
        $("#btnGuardaObservacion").click(function(){
            
            if(ValidaObservacionArchivo())
            {
                if($("#txtArchivo")[0].files[0] != null){
                    
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress',function(ev){
                        console.log((ev.loaded/ev.total)+'%');
                    }, false);
                    xhr.onreadystatechange = function(ev){
                        if(xhr.readyState==4 && xhr.status==200)
                        {
                            var data = ev.currentTarget.responseText;
                            var obj = jQuery.parseJSON(data);
                            if(obj.estado == 'OK'){
                               $("#hdnIdArchivo").val(obj.id);
                               GuardarObservacion();    
                            }
                            else{
                                MostrarError(obj.msj, null);
                            }
                        }
                    };
                    xhr.open('POST', "./BO/UploadArchivo.php", true);
                    var files = $("#txtArchivo")[0].files;
                    var data = new FormData();
                    for(var i = 0; i < files.length; i++) data.append('file'+i, files[i]);
                    xhr.send(data);
                }
                else
                {
                    GuardarObservacion();               
                }
            }
        });
        
        <?php
        if($soy_dev == TRUE){
        ?>
            $("#txtNombre").prop('disabled', true);
            $("#txtDescripcion").prop('disabled', true);
            $("#txtCorreoCopia").prop('disabled', true);
            
            $('#ddlProyecto').prop('disabled',true);
            $('#ddlProyecto').selectpicker('refresh');
            
            $('#ddlPrioridad').prop('disabled',true);
            $('#ddlPrioridad').selectpicker('refresh');
            
            $('#ddlCategoria').prop('disabled',true);
            $('#ddlCategoria').selectpicker('refresh');
            
            $('#ddlEstado').find('[value=6]').prop('disabled',true);
            $('#ddlEstado').find('[value=5]').prop('disabled',true);
            $('#ddlEstado').find('[value=1]').prop('disabled',true);
            $('#ddlEstado').find('[value=2]').prop('disabled',true);
            $('#ddlEstado').selectpicker('refresh');
            
            // Si no esta asignada a mi, deshabilito botones
            var usu = $('#ddlUsuario').val();
            if(<?php echo $usu_id; ?> != usu){
                $("#btnGuardar").prop('disabled', true);
                $("#btnGuardaObservacion").prop('disabled', true);
            }
            
        <?php
        }
        ?>

    });
    
    function GuardarObservacion(){
        $.post("./BO/GuardarObservacionSolicitud.php", $('#FormPrincipal').serialize(),
            function(data) {
                var obj = jQuery.parseJSON(data);
                
                var msj = obj.html;
                var sub_msj = obj.errores; 
                
                var estado =  obj.estado;
                if(estado == 'OK') // Exito
                {
                    guardoObs = true;
                    MostrarExito(msj, sub_msj);
                }
                else // Error
                {
                    MostrarError(msj, sub_msj);
                }
                oTabla.fnReloadAjax();
                $("#hdnIdArchivo").val("");
                $("#txtArchivo").val("");
                $("#txtObservacion").val("");
        });
    }
    
    function ValidaObservacionArchivo(){
        
        var errores = [];
        
        var obs = $("#txtObservacion").val();
        
        if(!ValidaTexto(obs,1000)){
            errores.push(" - La observación es inválida.");
        }
        
        var archivo = $("#txtArchivo")[0].files[0];
        
        if(archivo != null){
            if(archivo.size / 1048576 > <?php echo $V_MAXIMO_MB ?> )
            {
                errores.push(" - Tamaño máximo excedido.");
            }
            if(!ValidaExtensiones(archivo.name)){
                errores.push(" - Extensión inválida.");
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
    
    function ValidaExtensiones(file)
    {
        if (file != "") {
            var extension = file.split(".");
            var ext = extension[extension.length - 1];
            ext = ext.toLowerCase();
            var extensiones = "<?php echo $V_EXT_VALIDAS ?>";
            var resultado = extensiones.indexOf(ext);
            if (resultado > -1) {
                return true;
            }
            if (extensiones == '*') {
                return true;
            }
        }
        return false;
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
      
      if(guardoObs == false){
         errores.push(" - Debe ingresar al menos una observación."); 
      }
      
      <?php // Si soy desarrollador
      if($soy_dev == TRUE){
      ?>
        var estado = $('#ddlEstado').val();
        if(estado != 3 && estado != 4){
            errores.push(" - Debe seleccionar un estado válido para la solicitud.");
        }
        
        var usu = $('#ddlUsuario').val();
        if(<?php echo $usu_id; ?> == usu){
            errores.push(" - Debe asignar la solicitud a un usuario válido.");
        }

      <?php
      }
      ?>

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
    
    function DescargarArchivo(idArchivo){
        $().redirect('./BO/DownloadArchivo.php', {'idArchivo': idArchivo});
    }

</script>
<!-- Contenido  -->
<fieldset>
    <legend>Detalle Solicitud</legend>

    <div class="row-fluid">
        <div class="span1"></div>
        <div class="span5">
            <label>
                <div>
                    Código <small class="text-error req"></small>
                </div></label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_NUMERO; ?>" class="input-xlarge" id="txtCodigo" name="txtCodigo" disabled >
            <label>
                <div>
                    Nombre <small class="text-error req">*</small>
                </div></label>
            <input type="text" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtNombre" name="txtNombre" >
    
            <?php
            $obj = new Utilidades($V_HOST, $V_USER, $V_PASS, $V_BBDD);
            echo $obj->GeneraSelectProyectos("ddlProyecto", false, true, 5);
            echo $obj->GeneraSelectUsuarios("ddlUsuario", false, true, 5);
            ?>
    
            <label>
                <div>
                    Descripción <small class="text-error req">*</small>
                </div></label>
            <textarea rows="3" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" class="input-xlarge" id="txtDescripcion" name="txtDescripcion"></textarea>
              
        </div>
        <div class="span5">
    
            <?php
            echo $obj->GeneraSelectEstadoSolicitud("ddlEstado", false, true, 5);
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
                Guardar
            </button>
            <button type="button" class="btn btn-lg btn-primary" id="btnVolver">
                Volver
            </button>
        </p>
    </div>
</div>
<div id="divErrores" style="width: 60%;"></div>

<fieldset>
    <legend>Observaciones</legend>
    
    <div class="row-fluid">
        <div class="span6"></div>
        <div class="span2">
            <div>Ver Observaciones</div>
        </div>
        <div class="span1">
            <a class="btn btn-info" href="javascript:OcultaObservaciones();"><i id="btnOcultaObservaciones" class="icon-chevron-down"></i></a>
        </div>
        <div class="span2">
            <div>Agregar Observación</div>
        </div>
        <div class="span1">
            <a class="btn btn-info" href="javascript:OcultaAgregaObs();"><i id="btnOcultaAgregaObs" class="icon-chevron-down"></i></a>
        </div>
    </div>
    
    <div class="row-fluid filtroAvanzadoAgregaObs">
        <div class="span6">
            
            <label>
                <div>
                    Observación <small class="text-error req">*</small>
                </div></label>
            <textarea rows="5" placeholder="<?php echo $V_MSG_PH_TEXT; ?>" style="width: 90%;" id="txtObservacion" name="txtObservacion"></textarea>
            <label></label>
            <button type="button" class="btn btn-lg btn-primary" id="btnGuardaObservacion">
                Agregar Observación/Archivo
            </button>
        </div>
        <div class="span5">
            <label>Archivo</label>
            <input type="file" id="txtArchivo" name="txtArchivo" />
            <label></label>
            <label>
                <div><small class="text-error req">(Extensiones:<?php echo $V_EXT_VALIDAS; ?>. Tamaño máximo: <?php echo $V_MAXIMO_MB; ?>MB.)</small>
                </div>
            </label>
        </div>
        <div class="span1"></div>
    </div>
    <div>
        &nbsp;
    </div>
    <div class="row-fluid filtroAvanzado">
        <div  class="span12">
            <table id="tblObservaciones" class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th style="width: 50%;">Observación</th>
                        <th>Nombre Archivo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>Histórico</legend>
    
    <div class="row-fluid" >
        <div class="span9"></div>
        <div class="span2">
            <div>Ver Histórico</div>
        </div>
        <div class="span1">
            <a class="btn btn-info" href="javascript:OcultaHistorico();"><i id="btnOcultaHistorico" class="icon-chevron-down"></i></a>
        </div>
    </div>

    <div class="row-fluid filtroAvanzadoH">
        <div  class="span12">
            <table id="tblHistorico" class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th style="width: 40%;">Descripción</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th>Prioridad</th>
                        <th>Categoría</th>
                        <th>Proyecto</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</fieldset>


<div>
    &nbsp;
</div>

<!-- Hiddens -->
<div style="display: none;">
    <input type="hidden" id="hdnIdSolicitud" name="hdnIdSolicitud" />
    <input type="hidden" id="hdnIdArchivo" name="hdnIdArchivo" />
</div>

<?php

include ("footer.php");
?>

