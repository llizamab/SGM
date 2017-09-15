<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdCliente = (isset($_POST['hdnIdCliente']))? $_POST['hdnIdCliente'] : "";
$txtCorreo = (isset($_POST['txtCorreo']))? $_POST['txtCorreo'] : "";
$txtRut = (isset($_POST['txtRut']))? $_POST['txtRut'] : "";
$txtDireccion = (isset($_POST['txtDireccion']))? $_POST['txtDireccion'] : "";
$txtApellido = (isset($_POST['txtApellido']))? $_POST['txtApellido'] : "";
$txtNombreCliente = (isset($_POST['txtNombreCliente']))? $_POST['txtNombreCliente'] : "";
$txtNombreEmpresa = (isset($_POST['txtNombreEmpresa']))? $_POST['txtNombreEmpresa'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($hdnIdCliente) > 0)
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");

        $queryUpdUsu = "UPDATE tsg_cliente SET
                             cli_nombre = '$txtNombreCliente'
                            ,cli_apellido = '$txtApellido'
                            ,cli_correo = '$txtCorreo'
                            ,cli_empresa = '$txtNombreEmpresa' 
                            ,cli_rut = '$txtRut'
                            ,cli_direccion = '$txtDireccion'
                            ,cli_fecha_mod = NOW()
                        WHERE cli_id = $hdnIdCliente AND cli_activo = 1  ";
        
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