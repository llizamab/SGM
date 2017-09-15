<?php
require("../config/parametros.php");

$data = array();

$_SESSION["Post-obs"] = $_POST;
$_SESSION["Files-obs"] = $_FILES;

if($_FILES["file0"]['size'] > 0)
{
    $mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
    if($mySqli->connect_errno)
    {
        $data["Error conexion MySql"] = $mySqli->connect_error;
    }
    
    $fileName = $_FILES["file0"]['name'];
    $tmpName  = $_FILES["file0"]['tmp_name'];
    $fileSize = $_FILES["file0"]['size'];
    $fileType = $_FILES["file0"]['type'];
    
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    
    if(!get_magic_quotes_gpc())
    {
        $fileName = addslashes($fileName);
    }
    
    $query = "INSERT INTO tsg_archivo (arc_nombre, arc_peso, type, content )
              VALUES ('$fileName', '$fileSize', '$fileType', '$content');";

    $res = $mySqli->query($query);
        
    if($mySqli->affected_rows > 0) // No existe el nombre
    {
        $data["estado"] = "OK";
        $data["id"] = $mySqli->insert_id;
        $data["msj"] = "";
    }
    else
    {
        $data["estado"] = "KO";
        $data["msj"] = "Ha ocurrido un error al insertar el archivo en BBDD";
    }
}
else
{
    $data["estado"] = "KO";
    $data["msj"] = "El archivo pesa 0 MB";
}

echo json_encode($data);

?>