<?php
require("../config/parametros.php");
$data = array();
$msg = "";
$usu_id = $_SESSION["id_usuario"];
$usu_nom = $_SESSION['usuario'];

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

if(strlen($usu_id) > 0)
{
    $querySelect = "SELECT 1 FROM tsg_cliente WHERE cli_rut = '$txtRut' AND cli_activo = 1 ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows < 1)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");

        $queryIns = "INSERT INTO tsg_cliente (cli_nombre, cli_apellido, cli_correo, cli_empresa, cli_rut, cli_direccion, cli_fecha_ini, cli_activo, cli_usu_creador) 
                     VALUES
                        ('$txtNombreCliente',
                         '$txtApellido',
                         '$txtCorreo',
                         '$txtNombreEmpresa',
                         '$txtRut',
                         '$txtDireccion',
                         NOW(),
                         1,
                         '$usu_nom');";
        
        $res = $mySqli->query($queryIns);
        
        if($mySqli->errno == 0)
        {
            if($mySqli->affected_rows > 0)
            {
                $msg = "Se ha creado el cliente correctamente";
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
           $msg = "Error al registrar el cliente";
           $data["estado"] = "KO";
        }
    }
    else{
        $msg = "Ya existe el usuario $txtRut";
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