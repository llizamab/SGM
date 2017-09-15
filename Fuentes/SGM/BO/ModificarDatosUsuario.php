<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$Nombre = (isset($_POST['txtNombre']))? $_POST['txtNombre'] : "";
$Apellido = (isset($_POST['txtApellido']))? $_POST['txtApellido'] : "";
$Telefono = (isset($_POST['txtTelefono']))? $_POST['txtTelefono'] : "";
$Direccion = (isset($_POST['txtDireccion']))? $_POST['txtDireccion'] : "";
$Correo = (isset($_POST['txtCorreo']))? $_POST['txtCorreo'] : "";


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

$pass = generar_Hash($pass, $V_LLAVE);

if(strlen($usu_id) > 0)
{
	$querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
	$res = $mySqli->query($querySelect);
		
	if($mySqli->affected_rows > 0) // No existe el nombre
	{
	    $mySqli->autocommit(FALSE);
	    $mySqli->query("SET NAMES 'utf8'");
	    $mySqli->query("SET CHARACTER SET 'utf8'");

	    $queryUpdUsu = "UPDATE `tsg_usuario` SET
	                        
	                         `usu_nombre` = '$Nombre'
	                        ,`usu_apellido` = '$Apellido'
	                        ,`usu_telefono` = '$Telefono'
	                        ,`usu_direccion` = '$Direccion' 
	                        ,`usu_fecha_mod` = NOW()
	                        ,`usu_correo` = '$Correo'
	                        
                        WHERE `usu_id` = $usu_id AND `usu_activo` = 1 ";
	    
	    $res = $mySqli->query($queryUpdUsu);
	    
	    if($mySqli->errno == 0)
	    {
	        if($mySqli->affected_rows > 0)
	        {
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
    $data["html"] = "$msg - $querySelect - $queryInsUsu - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);

?>