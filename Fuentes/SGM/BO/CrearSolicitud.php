<?php
require("../config/parametros.php");
$data = array();
$msg = "";

$usu_id = $_SESSION["id_usuario"];
$usu_nom = $_SESSION['usuario'];

$txtNombre      = (isset($_POST['txtNombre']))? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion']))? $_POST['txtDescripcion'] : "";
$txtCorreoCopia = (isset($_POST['txtCorreoCopia']))? $_POST['txtCorreoCopia'] : "";
$ddlProyecto    = (isset($_POST['ddlProyecto']))? $_POST['ddlProyecto'] : "";
$ddlPrioridad   = (isset($_POST['ddlPrioridad']))? $_POST['ddlPrioridad'] : "";
$ddlCategoria   = (isset($_POST['ddlCategoria']))? $_POST['ddlCategoria'] : "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $data["Error conexion MySql"] = $mySqli->connect_error;
}

if(strlen($usu_id) > 0)
{
    $mySqli->autocommit(FALSE);
    $mySqli->query("SET NAMES 'utf8'");
    $mySqli->query("SET CHARACTER SET 'utf8'");

    $queryIns = "INSERT INTO tsg_ticket (tic_nombre,
                                         tic_descripcion,
                                         tic_fecha_crea,
                                         tsg_estado_ticketest_id,
                                         tsg_usuariousu_id,
                                         tsg_proyectopro_id,
                                         tsg_prioridadpri_id,
                                         tsg_categoriacat_id,
                                         tic_destcado,
                                         tsg_tic_correo_en_copia)
                 VALUES
                    ('$txtNombre',
                     '$txtDescripcion',
                      NOW(),
                      1,
                     '$usu_id',
                     '$ddlProyecto',
                     '$ddlPrioridad',
                     '$ddlCategoria',
                      0,
                     '$txtCorreoCopia');";

    $res = $mySqli->query($queryIns);
    
    if($mySqli->errno == 0)
    {
        if($mySqli->affected_rows > 0)
        {
            $idSolicitud = $mySqli->insert_id;
            $msg = "Se ha creado la solicitud $idSolicitud correctamente";
            
            $queryInsertH = "INSERT INTO tsg_historico_ticket (his_nombre,
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
                        WHERE tick.tic_id = $idSolicitud ";
                        
            $res = $mySqli->query($queryInsertH);
                        
            $mySqli->commit();
            $mySqli->close();
            $data["estado"] = "OK";
            
            $objEstadistica = new RegistraEstadistica($V_HOST, $V_USER, $V_PASS, $V_BBDD);
            $objEstadistica->RegistraEstadistica("1", $ddlProyecto);
            
            $objMail = new EnvioMail($V_HOST_SMTP,$V_PORT_SMTP,$V_USER_SMTP,$V_PASS_SMTP,$V_FROM,$V_FROM_NAME,$V_HOST, $V_USER, $V_PASS, $V_BBDD);
            $objMail->enviarCorreoCreacionSolicitud($idSolicitud);
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
       $msg = "Error al registrar la solicitud";
       $data["estado"] = "KO";
    }
}
else{
    $msg = "El Usuario no es válido";
    $data["estado"] = "KO";
}

if($V_DEPURAR == TRUE)
{
    $data["html"] = "$msg - $queryIns ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data);
?>