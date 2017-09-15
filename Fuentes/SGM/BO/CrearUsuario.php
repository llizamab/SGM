<?php
require("../config/parametros.php");
$data = array();
$msg = "";
$usu_id = $_SESSION["id_usuario"];

$txtNombreUsuario = (isset($_POST['txtNombreUsuario']))? $_POST['txtNombreUsuario'] : "";
$txtApellido = (isset($_POST['txtApellido']))? $_POST['txtApellido'] : "";
$txtDireccion = (isset($_POST['txtDireccion']))? $_POST['txtDireccion'] : "";
$txtTelefono = (isset($_POST['txtTelefono']))? $_POST['txtTelefono'] : "";
$txtNombreRut = (isset($_POST['txtNombreRut']))? $_POST['txtNombreRut'] : "";
$txtPass = (isset($_POST['txtPass']))? $_POST['txtPass'] : "";
$txtCorreo = (isset($_POST['txtCorreo']))? $_POST['txtCorreo'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0)
{
    $querySelect = "SELECT 1 FROM tsg_usuario WHERE usu_rut = '$txtNombreRut' AND usu_activo = 1 ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows < 1)
    {
        $txtPass = generar_Hash($txtPass, $V_LLAVE);
        
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");

        $queryIns = "INSERT INTO tsg_usuario (`usu_nombre`, `usu_apellido`, `usu_telefono`, `usu_direccion`, `usu_rut`, `usu_pass`, `usu_correo`, `usu_activo`, usu_fecha_crea) 
                     VALUES
                        ('$txtNombreUsuario',
                         '$txtApellido',
                         '$txtTelefono',
                         '$txtDireccion',
                         '$txtNombreRut',
                         '$txtPass',
                         '$txtCorreo',
                         1,
                         NOW());";
        
        $res = $mySqli->query($queryIns);
        
        if($mySqli->errno == 0)
        {
            if($mySqli->affected_rows > 0)
            {

                $msg = "Se ha creado el usuario correctamente";
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
           $msg = "Error al registrar el usuario";
           $data["estado"] = "KO";
        }
    }
    else{
        $msg = "Ya existe el usuario $txtNombreRut";
        $data["estado"] = "KO";
    }
}
else{
    $msg = "El Usuario no es válido";
    $data["estado"] = "KO";
}

if($V_DEPURAR == TRUE)
{
    $data["html"] = "$msg - $querySelect - $queryIns ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);

?>