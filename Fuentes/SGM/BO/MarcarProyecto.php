<?php
require("../config/parametros.php");

$usu_id = $_SESSION["id_usuario"];
$msg = "";

$idProyecto = (isset($_POST['idProyecto']))? $_POST['idProyecto'] : NULL;
$marca      = (isset($_POST['marca']))? $_POST['marca'] : NULL;


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($idProyecto) > 0 && strlen($marca) > 0 && strlen($usu_id) > 0)
{
	$querySelect = "SELECT 1 FROM `tsg_proyecto` WHERE `pro_id` = $idProyecto AND pro_activo = 1 ";
	$res = $mySqli->query($querySelect);
		
	if($mySqli->affected_rows > 0)
	{
	    $mySqli->autocommit(FALSE);
	    $mySqli->query("SET NAMES 'utf8'");
	    $mySqli->query("SET CHARACTER SET 'utf8'");

	    $queryUpdUsu = "UPDATE `tsg_proyecto` SET
	                           `pro_destacado` = $marca
                         WHERE `pro_id` = $idProyecto AND pro_activo = 1 ";
	    
	    $res = $mySqli->query($queryUpdUsu);
	    
	    if($mySqli->errno == 0)
	    {
	        if($mySqli->affected_rows > 0)
	        {
	            $msg = "Se han guardado los cambios correctamente";
	            $mySqli->commit();
	            $mySqli->close();
	        }
	        else {
	           $mySqli->rollback(); 
	           $mySqli->close();
	           $msg = "No se han realizado cambios";
	        }
	    }
	    else {
	       $mySqli->rollback(); 
	       $mySqli->close();
	       $msg = "Error al modificar los datos";
	    }
	}
}

if($V_DEPURAR == TRUE)
{
    $_SESSION["BO-MarcaProyecto-SQL"] = $msg ." - " .$querySelect . " - " . $queryUpdUsu;
	$_SESSION["BO-MarcaProyecto-Post"] = $_POST;
}

?>