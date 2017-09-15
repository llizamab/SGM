<?php
require_once("../config/parametros.php");

$pass   = $_POST['pass'];
$id     = str_replace(" ", "", $_POST['name']);
$pass   = generar_Hash($pass, $V_LLAVE);

$data = array();

$query = "SELECT `usu_id`,`usu_nombre` FROM `tsg_usuario` WHERE `usu_rut` = '$id' AND `usu_pass` = '$pass' AND `usu_activo` = 1 ";
$usu_id;
$nombre;

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

$res = $mySqli->query($query);

if($mySqli->affected_rows > 0) // Si los datos son validos
{
	while($row = $res->fetch_assoc())
	{
		$nombre = $row['usu_nombre'];
		$usu_id = $row['usu_id'];
	}
	
	@session_start(); // Guardo la sesion
    $_SESSION['usuario'] = $nombre;
    $_SESSION['id_usuario'] = $usu_id;
    $data["error"] = FALSE;
    
    // Obtener los roles asociados
    $query = "SELECT rol.rol_id, rol.rol_nombre
              FROM tsg_rol rol
              INNER JOIN tsg_usuario_tsg_rol usu_rol
              ON rol.rol_id = usu_rol.tsg_rolrol_id
              WHERE rol.rol_activo = 1 AND
                    usu_rol.tsg_usuariousu_id = $usu_id ";
                    
    $res = $mySqli->query($query);
    {
        if($mySqli->affected_rows > 0) 
        {
            $roles = array();
            
            while($row = $res->fetch_assoc())
            {
                 $roles[$row["rol_id"]] = $row["rol_nombre"]; 
            }
            $_SESSION['roles'] = $roles;
        }
    }
    $mySqli->close();
}
else /* Si no lo son retornar un mensaje */
{
    if($V_DEPURAR == TRUE)
    {
        $data["html"] = "- Debe ingresar un RUT y/o Contraseña válida. - ".$query;
    }
    else 
    {
        $data["html"] = "- Debe ingresar un RUT y/o Contraseña válida.";  
    }
	$data["error"] = TRUE;
}

echo json_encode($data);

?>