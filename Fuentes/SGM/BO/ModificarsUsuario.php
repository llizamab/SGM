<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdUsuario = (isset($_POST['hdnIdUsuario']))? $_POST['hdnIdUsuario'] : "";
$txtNombreUsuario = (isset($_POST['txtNombreUsuario']))? $_POST['txtNombreUsuario'] : "";
$txtApellido = (isset($_POST['txtApellido']))? $_POST['txtApellido'] : "";
$txtDireccion = (isset($_POST['txtDireccion']))? $_POST['txtDireccion'] : "";
$txtTelefono = (isset($_POST['txtTelefono']))? $_POST['txtTelefono'] : "";
$txtNombreRut = (isset($_POST['txtNombreRut']))? $_POST['txtNombreRut'] : "";
$txtCorreo = (isset($_POST['txtCorreo']))? $_POST['txtCorreo'] : "";
$txtPass = (isset($_POST['txtPass']))? $_POST['txtPass'] : "";


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($hdnIdUsuario) > 0)
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");

        $queryUpdUsu = "UPDATE tsg_usuario SET
                             usu_nombre = '$txtNombreUsuario'
                            ,usu_apellido = '$txtApellido'
                            ,usu_telefono = '$txtTelefono'
                            ,usu_direccion = '$txtDireccion' 
                            ,usu_correo = '$txtCorreo'
                            ,usu_fecha_mod = NOW()
                        WHERE usu_id = $hdnIdUsuario AND usu_activo = 1 ";
        
        $res = $mySqli->query($queryUpdUsu);
        
        if($mySqli->errno == 0)
        {
            // Solo si cambio la contraseña, ingresarla
            if(strlen($txtPass) > 0){
                $txtPass = generar_Hash($txtPass, $V_LLAVE);
                $queryInsert = "UPDATE tsg_usuario SET
                                       usu_pass = '$txtPass'
                                WHERE usu_id = $hdnIdUsuario AND usu_activo = 1 ";
                                
                $res = $mySqli->query($queryInsert);
            }

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
    $data["html"] = "$msg - $querySelect - $queryInsert - $queryUpdUsu ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);

?>