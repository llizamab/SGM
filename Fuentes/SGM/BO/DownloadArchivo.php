<?php

if(isset($_POST['idArchivo'])) 
{
    require("../config/parametros.php");
    
    $id    = $_POST['idArchivo'];
    $size;
    $type;
    $name;
    $content;
    
    $query = "SELECT arc_nombre, type, arc_peso, content
              FROM tsg_archivo WHERE arc_id = '$id'";
    
    $mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
    if($mySqli->connect_errno)
    {
        $data["Error conexion MySql"] = $mySqli->connect_error;
    }
    
    $res = $mySqli->query($query);

    if($mySqli->affected_rows > 0)
    {
        while($row = $res->fetch_assoc())
        {
            $size = $row["arc_peso"];
            $type = $row["type"];
            $name = $row["arc_nombre"];
            $content = $row["content"];
        }
    }
    
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo $content; 
    exit;
}
?>
