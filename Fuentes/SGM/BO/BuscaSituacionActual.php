<?php
require("../config/parametros.php");
$data = array();
$data["estado"] = "OK";
$super_array = array();
$proyectos = array();
$msg = "";

$ddlProyecto = (isset($_POST['ddlProyecto']))? $_POST['ddlProyecto'] : NULL;
$ddlCliente = (isset($_POST['ddlCliente']))? $_POST['ddlCliente'] : NULL;

$Alta  = 0;
$Media = 0;
$Baja  = 0;

for($x = 1; $x < 4; $x++){
    $idPriori = "$x";
    
    $query = "SELECT COUNT(1) AS CONT FROM tsg_ticket tick 
                          INNER JOIN tsg_proyecto pry ON tick.tsg_proyectopro_id = pry.pro_id
                          INNER JOIN tsg_cliente cli ON cli.cli_id = pry.tsg_clientecli_id
              WHERE tick.tsg_prioridadpri_id = $idPriori AND tick.tsg_estado_ticketest_id NOT IN (5,6) ";

    if($ddlProyecto != null && is_array($ddlProyecto) && count($ddlProyecto) > 0)
    {
        $query .= " AND tick.tsg_proyectopro_id IN (";
        foreach($ddlProyecto as $obj){
            $query .= "$obj,";
        }
        $query = substr($query,0, -1).")";
    }
    
    if($ddlCliente != null && is_array($ddlCliente) && count($ddlCliente) > 0)
    {
        $query .= " AND pry.tsg_clientecli_id IN (";
        foreach($ddlCliente as $obj){
            $query .= "$obj,";
        }
        $query = substr($query,0, -1).")";
    }
     
    $mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
    
    if($mySqli->connect_errno)
    {
        $data["html"] = "Error conexion MySql";
        $data["estado"] = "KO";
        echo json_encode($data);
        die;
    }
    
    $res = $mySqli->query($query);
    if($mySqli->affected_rows > 0)
    {
        while($row = $res->fetch_assoc())
        {
            switch ($x) {
                case 3:
                    $Alta = $row["CONT"];
                break;
                case 2:
                    $Media = $row["CONT"];
                break;
                case 1:
                    $Baja = $row["CONT"];
                break;
            }
        }
    }
    $mySqli->close();
}

$data["array"] = array(3 => $Alta,2 => $Media,1 => $Baja);

if($V_DEPURAR == TRUE)
{
    $data["html"] = "$msg - $query ";
}
else 
{
    $data["html"] = "$msg";
}

echo json_encode($data, JSON_NUMERIC_CHECK);

?>