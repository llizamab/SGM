<?php
include("cabecera.php");
include("menu.php");

$usu_id = $_SESSION["id_usuario"];

$PerfilesActuales = array();
$PerfilesDisponibles = array();

$IdUsuario = $_POST["IdUsuario"];

if ($IdUsuario == NULL || $usu_id == NULL || strlen($IdUsuario) < 1) {
	echo $V_ACCES_DENIED;
	exit();
}

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
$mySqli->query("SET NAMES 'utf8'");
$mySqli->query("SET CHARACTER SET 'utf8'");

$query = "SELECT usu_rol.tsg_rolrol_id, 
                 rol.rol_nombre
          FROM tsg_usuario_tsg_rol usu_rol
            INNER JOIN tsg_rol rol
            ON rol.rol_id = usu_rol.tsg_rolrol_id AND rol.rol_activo = 1
          WHERE usu_rol.tsg_usuariousu_id = $IdUsuario ";

$res = $mySqli -> query($query);

if ($mySqli -> affected_rows > 0)
{
    while ($row = $res -> fetch_assoc()) {
        $PerfilesActuales[$row['tsg_rolrol_id']] = $row['rol_nombre'];
    }
}

$query = "SELECT rol_id, rol_nombre
          FROM tsg_rol rol
          WHERE rol.rol_activo = 1
          AND NOT EXISTS (SELECT 1 FROM tsg_usuario_tsg_rol usu_rol
                          WHERE usu_rol.tsg_rolrol_id = rol.rol_id 
                                AND usu_rol.tsg_usuariousu_id = $IdUsuario)";

$res = $mySqli -> query($query);

if ($mySqli -> affected_rows > 0)
{
    while ($row = $res -> fetch_assoc()) {
        $PerfilesDisponibles[$row['rol_id']] = $row['rol_nombre'];
    }
}

?>
<script type="text/javascript">

$(function() {
    
    $("#collapse<?php echo "3"; ?>").collapse('show');
    $("#busqueda_usuario").addClass("btn-info");
	
	$('#btn-add').click(function(){
        $('#PerAsignados option:selected').each( function() {
            $('#PerListado').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
    $('#btn-remove').click(function(){
        $('#PerListado option:selected').each( function() {
            $('#PerAsignados').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
    
    $("#btnVolver").click(function(){
    	$().redirect('modificar_usuario.php', {'idUsuario': <?php echo $IdUsuario; ?>});
    });
    
    $("#btnGuardar").click(function(){
    	bootbox.dialog({
          message: "¿Seguro que desea guardar los cambios?",
          title: null,
          buttons: {
            Si: {
              label: "Si",
              className: "btn-success",
              callback: function() {
                  
                    var perfs = [];
                    $("#PerAsignados option").each(function(data,x){
                        perfs.push(x.value);
                    });

                    $.post("./BO/ModificarDatosPerfiles.php", {IdUsuario : $('#hdnIdUsuario').val(), Perfiles : perfs},
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
    });
});

</script>
<!-- asignar perfiles -->
<fieldset>
    <legend>Asignar Perfiles</legend>

<div id="divErrores" style="width: 60%;"></div>

<div class="row-fluid pagination-centered">
	<div class="span1"></div>
    <div class="span10">
		<div class="row-fluid">
			<div class="span5">
				<select id='PerAsignados' name='PerAsignados[]' multiple size='10' style="width: 100%;">
				<?php 
				    foreach($PerfilesActuales as $key => $obj){
				        echo "<option value='$key'>$obj</option>";
				    }
				?>
				</select>
			</div>
			<div class="span2">
				<label></label>
				<div>&nbsp;</div>
				<label></label>
				<div>&nbsp;</div>
				
				<a class="btn btn-info" href='JavaScript:void(0);' id='btn-add'><i class="icon-chevron-right"></i></a>
				<label></label>
				<a class="btn btn-info" href='JavaScript:void(0);' id='btn-remove'><i class="icon-chevron-left"></i></a>
			</div>
			<div class="span5">
				<select id='PerListado' name='PerListado' multiple size='10' style="width: 100%;">
				<?php
				  foreach($PerfilesDisponibles as $key => $obj){
                        echo "<option value='$key'>$obj</option>";
                    }
				?>
				</select>
			</div>
		</div>    	
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

<div>
    &nbsp;
</div>
<div>
    &nbsp;
</div>

<div style="display: none;">
    <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $IdUsuario; ?>" />
</div>

<?php

include ("footer.php");
?>