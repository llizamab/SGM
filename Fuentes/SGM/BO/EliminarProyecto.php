<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdProyecto = (isset($_POST['IdProyecto']))? $_POST['IdProyecto'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($hdnIdProyecto) > 0)
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");
        
        $queryS = "SELECT 1 FROM tsg_ticket tick
                   WHERE tick.tsg_proyectopro_id = $hdnIdProyecto AND tick.tsg_estado_ticketest_id NOT IN (5,6); ";
        
        $res = $mySqli->query($queryS);
        
        if($mySqli->affected_rows > 0)
        {
           $mySqli->rollback(); 
           $mySqli->close();
           $msg = "No se puede eliminar el proyecto, tiene solicitudes en curso";
           $data["estado"] = "KO";
        }
        else
        {
            $queryUpdUsu = "UPDATE tsg_proyecto SET
                            pro_activo = 0
                        WHERE pro_id = $hdnIdProyecto ";
        
            $res = $mySqli->query($queryUpdUsu);
    
            if($mySqli->errno == 0)
            {
                if($mySqli->affected_rows > 0)
                {
                    $msg = "Se ha eliminado el proyecto correctamente";
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
               $msg = "Error al eliminar el proyecto";
               $data["estado"] = "KO";
            }   
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
    $data["html"] = "$msg - $querySelect - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);


?>