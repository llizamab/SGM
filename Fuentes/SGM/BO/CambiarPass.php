<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$pass = (isset($_POST['txtPassNueva']))? $_POST['txtPassNueva'] : NULL;
$passActual = (isset($_POST['txtPassActual']))? $_POST['txtPassActual'] : NULL;


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

$pass = generar_Hash($pass, $V_LLAVE);
$passActual = generar_Hash($passActual, $V_LLAVE);

if(strlen($usu_id) > 0 && strlen($pass) > 0 && strlen($passActual) > 0)
{
	$querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id AND `usu_pass` = '$passActual' AND `usu_activo` = 1 ";
	
	$res = $mySqli->query($querySelect);
		
	if($mySqli->affected_rows > 0) // No existe el nombre
	{
	    $mySqli->autocommit(FALSE);
	    $mySqli->query("SET NAMES 'utf8'");
	    $mySqli->query("SET CHARACTER SET 'utf8'");

	    $queryUpdUsu = "UPDATE `tsg_usuario` SET
	                        `usu_pass`  = '$pass'
                        WHERE `usu_id` = $usu_id ";
	    
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
	       $msg = "Error al modificar la contraseña";
	       $data["estado"] = "KO";
	    }
	}
	else{
		$msg = "Contraseña invalida";
		$data["estado"] = "KO";
	}
}
else{
	$msg = "Contraseña invalida";
	$data["estado"] = "KO";
}


if($V_DEPURAR == TRUE)
{
    $data["html"] = "$msg - $querySelect - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);


?>