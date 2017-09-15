<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];

$hdnIdSolicitud = (isset($_POST['hdnIdSolicitud']))? $_POST['hdnIdSolicitud'] : "";
$txtNombre = (isset($_POST['txtNombre']))? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion']))? $_POST['txtDescripcion'] : "";
$txtCorreoCopia = (isset($_POST['txtCorreoCopia']))? $_POST['txtCorreoCopia'] : "";
$ddlEstado = (isset($_POST['ddlEstado']))? $_POST['ddlEstado'] : "";
$ddlProyecto = (isset($_POST['ddlProyecto']))? $_POST['ddlProyecto'] : "";
$ddlCategoria = (isset($_POST['ddlCategoria']))? $_POST['ddlCategoria'] : "";
$ddlPrioridad = (isset($_POST['ddlPrioridad']))? $_POST['ddlPrioridad'] : "";
$ddlUsuario = (isset($_POST['ddlUsuario']))? $_POST['ddlUsuario'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0 && strlen($hdnIdSolicitud) > 0 )
{
    $querySelect = "SELECT 1 FROM `tsg_usuario` WHERE `usu_id` = $usu_id ";
    $res = $mySqli->query($querySelect);
        
    if($mySqli->affected_rows > 0)
    {
        $mySqli->autocommit(FALSE);
        $mySqli->query("SET NAMES 'utf8'");
        $mySqli->query("SET CHARACTER SET 'utf8'");
        
        $roles = $_SESSION['roles'];
        if(is_array($roles) && count($roles) == 1 && $roles[4] != ""){
            $queryUpdUsu = "UPDATE tsg_ticket SET
                             tic_fecha_crea = NOW()
                            ,tsg_estado_ticketest_id = '$ddlEstado'
                            ,tsg_usuariousu_id = '$ddlUsuario'
                            
                        WHERE tic_id = $hdnIdSolicitud ";
        }
        else{
            $queryUpdUsu = "UPDATE tsg_ticket SET
                            
                             tic_nombre = '$txtNombre'
                            ,tic_fecha_crea = NOW()
                            ,tic_descripcion = '$txtDescripcion'
                            ,tsg_estado_ticketest_id = '$ddlEstado'
                            ,tsg_usuariousu_id = '$ddlUsuario'
                            ,tsg_proyectopro_id = '$ddlProyecto'
                            ,tsg_prioridadpri_id = '$ddlPrioridad'
                            ,tsg_categoriacat_id = '$ddlCategoria'
                            ,tsg_tic_correo_en_copia = '$txtCorreoCopia'
                            
                        WHERE tic_id = $hdnIdSolicitud ";   
        }

        $res = $mySqli->query($queryUpdUsu);

        if($mySqli->errno == 0)
        {
            if($mySqli->affected_rows > 0)
            {
                $msg = "Se han guardado los cambios correctamente";
                
                        $queryInsert = "INSERT INTO tsg_historico_ticket (his_nombre,
                                                          his_fecha,
                                                          his_descrip,
                                                          tsg_estado_ticketest_id,
                                                          tsg_tickettic_id,
                                                          tsg_usuariousu_id,
                                                          tsg_proyectopro_id,
                                                          tsg_prioridadpri_id,
                                                          tsg_categoriacat_id)
                                SELECT tick.tic_nombre,
                                       tick.tic_fecha_crea,
                                       tick.tic_descripcion,
                                       tick.tsg_estado_ticketest_id,
                                       tick.tic_id,
                                       tick.tsg_usuariousu_id,
                                       tick.tsg_proyectopro_id,
                                       tick.tsg_prioridadpri_id,
                                       tick.tsg_categoriacat_id
        
                                FROM tsg_ticket tick
                                WHERE tick.tic_id = $hdnIdSolicitud ";
                
                $res = $mySqli->query($queryInsert);
        
                $mySqli->commit();
                $mySqli->close();
                $data["estado"] = "OK";
                
                $objEstadistica = new RegistraEstadistica($V_HOST, $V_USER, $V_PASS, $V_BBDD);
                $objEstadistica->RegistraEstadistica($ddlEstado, $ddlProyecto);
                
                $objMail = new EnvioMail($V_HOST_SMTP,$V_PORT_SMTP,$V_USER_SMTP,$V_PASS_SMTP,$V_FROM,$V_FROM_NAME,$V_HOST, $V_USER, $V_PASS, $V_BBDD);
                $objMail->enviarCorreoModificacionSolicitud($hdnIdSolicitud);
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