<?php
require("../config/parametros.php");

$aaData = array();
$usu_id = $_SESSION["id_usuario"];
$msg = "";

$IdSolicitud = (isset($_POST['IdSolicitud']))? $_POST['IdSolicitud'] : NULL;

$query = "SELECT tick.his_id,
                 tick.his_fecha,
                 tick.his_nombre,
                 tick.his_descrip,
                 est_tick.est_nombre,
                 usu.usu_nombre,
                 usu.usu_rut,
                 pry.pro_nombre,
                 prio.pri_nombre,
                 cat.cat_nombre
                 
           FROM tsg_historico_ticket tick
            LEFT JOIN tsg_estado_ticket est_tick
            ON tick.tsg_estado_ticketest_id = est_tick.est_id
            
            LEFT JOIN tsg_usuario usu
            ON tick.tsg_usuariousu_id = usu.usu_id
            
            LEFT JOIN tsg_proyecto pry
            ON tick.tsg_proyectopro_id = pry.pro_id
            
            LEFT JOIN tsg_prioridad prio
            ON tick.tsg_prioridadpri_id = prio.pri_id
            
            LEFT JOIN tsg_categoria cat
            ON tick.tsg_categoriacat_id = cat.cat_id
            
           WHERE tick.tsg_tickettic_id = $IdSolicitud
           ORDER BY tick.his_id DESC; ";

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
                            $row['his_fecha'],
                            $row['his_nombre'],
                            $row['his_descrip'],
                            $row['est_nombre'],
                            $row['usu_rut']." - ".$row['usu_nombre'],
                            $row['pri_nombre'],
                            $row['cat_nombre'],
                            $row['pro_nombre']
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