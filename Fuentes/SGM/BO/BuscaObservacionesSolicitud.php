<?php
require("../config/parametros.php");

$aaData = array();
$usu_id = $_SESSION["id_usuario"];
$msg = "";

$IdSolicitud = (isset($_POST['IdSolicitud']))? $_POST['IdSolicitud'] : NULL;

$query = "SELECT obs.com_id, 
                 obs.com_descrip,
                 usu.usu_nombre,
                 arc.arc_id,
                 arc.arc_nombre,
                 arc.arc_url,
                 obs.com_fecha_creacion
          FROM tsg_comentario_ticket obs
            LEFT JOIN tsg_usuario usu 
            ON usu.usu_id = obs.tsg_usuariousu_id
            LEFT JOIN tsg_archivo arc
            ON obs.tsg_archivoarc_id = arc.arc_id
          WHERE obs.tsg_tickettic_id = $IdSolicitud 
          ORDER BY obs.com_id DESC ";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);

if($mySqli->connect_errno)
{
    $aErrores["Error conexion MySql"] = $mySqli->connect_error;
}
$mySqli->query("SET NAMES 'utf8'");
$mySqli->query("SET CHARACTER SET 'utf8'");
$res = $mySqli->query($query);

if($mySqli->affected_rows > 0)
{
    while($row = $res->fetch_assoc())
    {
        $aaData[] = array(  
                            $row['com_fecha_creacion'],
                            $row['usu_nombre'],
                            $row['com_descrip'],
                            $row['arc_nombre'],
                            (strlen($row["arc_id"]) > 0) ? "<a class=\"btn\" href=\"javascript:DescargarArchivo(".$row["arc_id"].");\"><i class=\"icon-download-alt\"></i></a>" : ""                                                        
                        );
     }
  
}

$aa = array(
     'sEcho' => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        'aaData' => $aaData);

if($V_DEPURAR == TRUE)
{
    $_SESSION["BObs-Query"] = $query;
    $_SESSION["BObs-Post"] = $_POST;
}
        
echo json_encode($aa);

?>