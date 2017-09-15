<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdSolicitud = (isset($_POST['hdnIdSolicitud']))? $_POST['hdnIdSolicitud'] : "";
$hdnIdArchivo  = (isset($_POST['hdnIdArchivo']))? $_POST['hdnIdArchivo'] : "NULL";
$txtObservacion  = (isset($_POST['txtObservacion']))? $_POST['txtObservacion'] : "";

if(strlen($hdnIdArchivo <= 0)){
    $hdnIdArchivo = "NULL";
}

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($hdnIdSolicitud) > 0)
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");

        $queryUpdUsu = "INSERT INTO tsg_comentario_ticket (com_descrip, tsg_tickettic_id, tsg_usuariousu_id, tsg_archivoarc_id, com_fecha_creacion)
                        VALUES ('$txtObservacion', $hdnIdSolicitud, $usu_id, '$hdnIdArchivo', NOW()); ";

        $res = $mySqli->query($queryUpdUsu);

        if($mySqli->errno == 0)
        {
            if($mySqli->affected_rows > 0)
            {
                $msg = "Se ha guardado la observación correctamente";
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
           $msg = "Error al guardar la observación";
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
    $data["html"] = "$msg - $querySelect - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);

?>