<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$IdUsuario = (isset($_POST['IdUsuario']))? $_POST['IdUsuario'] : "";
$Perfiles = (isset($_POST['Perfiles']))? $_POST['Perfiles'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($IdUsuario) > 0 )
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0) // No existe el nombre
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");
        
        $queryInsUsu =  "DELETE FROM tsg_usuario_tsg_rol WHERE tsg_usuariousu_id = $IdUsuario ";
        
        $res = $mySqli->query($queryInsUsu);

        if(is_array($Perfiles) && count($Perfiles) > 0){
            
            $queryUpdUsu = "INSERT INTO tsg_usuario_tsg_rol (tsg_usuariousu_id, tsg_rolrol_id) VALUES ";
            foreach($Perfiles as $obj){
                $queryUpdUsu .= "('$IdUsuario','$obj'),";
            }
            $queryUpdUsu = substr($queryUpdUsu, 0 , -1).";";
            $res = $mySqli->query($queryUpdUsu); 
        }

        if($mySqli->errno == 0)
        {
            $msg = "Se han guardado los cambios correctamente";
            $mySqli->commit();
            $mySqli->close();
            $data["estado"] = "OK";
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