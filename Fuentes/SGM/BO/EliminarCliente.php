<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$IdCliente = (isset($_POST['IdCliente']))? $_POST['IdCliente'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($IdCliente) > 0)
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0) // No existe el nombre
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");
        
        
        $queryS = "SELECT 1 FROM tsg_ticket tick
                   INNER JOIN tsg_proyecto pro ON tick.tsg_proyectopro_id = pro.pro_id
                   INNER JOIN tsg_cliente cli ON cli.cli_id  = pro.tsg_clientecli_id
                   WHERE cli.cli_id = $IdCliente AND tick.tsg_estado_ticketest_id NOT IN (5,6); ";
        
        $res = $mySqli->query($queryS);
        
        if($mySqli->affected_rows > 0)
        {
           $mySqli->rollback(); 
           $mySqli->close();
           $msg = "No se puede eliminar el cliente, tiene solicitudes en curso";
           $data["estado"] = "KO";
        }
        else
        {
            $queryUpdUsu = "UPDATE tsg_cliente SET
                              cli_activo = 0
                        WHERE cli_id = $IdCliente ";
        
            $res = $mySqli->query($queryUpdUsu);
    
            if($mySqli->errno == 0)
            {
                if($mySqli->affected_rows > 0)
                {
                    $msg = "Se ha eliminado el cliente correctamente";
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
               $msg = "Error al eliminar el cliente";
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