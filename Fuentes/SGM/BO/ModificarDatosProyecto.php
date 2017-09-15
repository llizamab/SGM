<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdProyecto = (isset($_POST['hdnIdProyecto']))? $_POST['hdnIdProyecto'] : "";
$txtNombreProyecto = (isset($_POST['txtNombreProyecto']))? $_POST['txtNombreProyecto'] : "";
$txtDuracion = (isset($_POST['hdnDuracion']))? $_POST['hdnDuracion'] : "";
$ddlJefeProyecto = (isset($_POST['ddlJefeProyecto']))? $_POST['ddlJefeProyecto'] : "";
$ddlCliente = (isset($_POST['ddlCliente']))? $_POST['ddlCliente'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion']))? $_POST['txtDescripcion'] : "";
$txtFechaInicio = (isset($_POST['txtFechaInicio']))? $_POST['txtFechaInicio'] : "";
$txtFechaTermino = (isset($_POST['txtFechaTermino']))? $_POST['txtFechaTermino'] : "";
$txtFechaGarantia = (isset($_POST['txtFechaGarantia']))? $_POST['txtFechaGarantia'] : "";
$ddlTipoProyecto = (isset($_POST['ddlTipoProyecto']))? $_POST['ddlTipoProyecto'] : "";
$ddlEstadoProyecto = (isset($_POST['ddlEstadoProyecto']))? $_POST['ddlEstadoProyecto'] : "";


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0)
{
	$querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
	$res = $mySqli->query($querySelect);
		
	if($mySqli->affected_rows > 0)
	{
	    $mySqli->autocommit(FALSE);
	    $mySqli->query("SET NAMES 'utf8'");
	    $mySqli->query("SET CHARACTER SET 'utf8'");
		
		$queryInsert = "INSERT INTO tsg_proyecto_historico (`prh_usuario`, `prh_fecha`, `tsg_proyectopro_id`, `sqi_tipo_proyectotip_id`, `tsg_estado_proyectoest_id`)
						SELECT  usu.usu_nombre,
								NOW(),
								pry.pro_id, 
								pry.sqi_tipo_proyectotip_id,
								pry.tsg_estado_proyectoest_id
						FROM tsg_proyecto pry
							LEFT JOIN tsg_usuario usu
							ON pry.pro_usu_id_jefepro = usu.usu_id AND usu.usu_activo = 1
						WHERE pry.pro_id = $hdnIdProyecto AND pry.pro_activo = 1";
		
		$res = $mySqli->query($queryInsert);

	    $queryUpdUsu = "UPDATE tsg_proyecto SET
	                        
	                         `pro_nombre` = '$txtNombreProyecto'
	                        ,`pro_duracion` = '$txtDuracion'
	                        ,`tsg_clientecli_id` = '$ddlCliente' 
	                        ,`pro_descrip` = '$txtDescripcion'
	                        ,`pro_fecha_ini` = STR_TO_DATE('$txtFechaInicio','%d-%m-%Y')
	                        ,`pro_fecha_term` = STR_TO_DATE('$txtFechaTermino','%d-%m-%Y')
	                        ,`pro_fecha_garan` = STR_TO_DATE('$txtFechaGarantia','%d-%m-%Y')
	                        ,`sqi_tipo_proyectotip_id` = '$ddlTipoProyecto'
	                        ,`tsg_estado_proyectoest_id` = '$ddlEstadoProyecto'
	                        ,pro_fecha_modificacion = NOW()
	                        
                        WHERE pro_id = $hdnIdProyecto AND pro_activo = 1 ";
	    
	    $res = $mySqli->query($queryUpdUsu);
	    
	    if($mySqli->errno == 0)
	    {
	        if($mySqli->affected_rows > 0)
	        {
	            if($ddlJefeProyecto != null && is_array($ddlJefeProyecto) && count($ddlJefeProyecto) > 0)
                {
                    $query = "DELETE FROM tsg_usuario_tsg_proyecto WHERE tsg_proyectopro_id = $hdnIdProyecto AND rol_id = 3;";
                    $res = $mySqli->query($query);
                    
                    foreach($ddlJefeProyecto as $obj){
                                
                         $query = "INSERT INTO tsg_usuario_tsg_proyecto (tsg_usuariousu_id, tsg_proyectopro_id, rol_id)
                                   VALUES ($obj, $hdnIdProyecto, 3);";
                                   
                         $res = $mySqli->query($query);
                    }
                }
	            
	            $msg = "Se han guardado los cambios correctamente";
	            $mySqli->commit();
	            $mySqli->close();
	            $data["estado"] = "OK";
	        }
	        else {
	           $mySqli->rollback(); 
	           $mySqli->close();
	           $msg = "No se han realizado cambios";
	           $data["estado"] = "OK";
	        }
	    }
	    else {
	       $mySqli->rollback(); 
	       $mySqli->close();
	       $msg = "Error al modificar los datos";
	       $data["estado"] = "KO";
	    }
	}
	else{
		$msg = "No existe el usuario";
		$data["estado"] = "KO";
	}
}
else{
	$msg = "El Usuario no es válido";
	$data["estado"] = "KO";
}


if($V_DEPURAR == TRUE)
{
    $data["html"] = "$msg - $querySelect - $queryInsert - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);

?>