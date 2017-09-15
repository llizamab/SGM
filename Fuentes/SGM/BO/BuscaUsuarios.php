<?php
require("../config/parametros.php");
//http://localhost:8080/sgm-lazos/Proyecto/Fuentes/SGM/BO/BuscaUsuarios.php

$aaData = array();

$Rut = (isset($_POST['txtRut']))? $_POST['txtRut'] : NULL;
$Nombre = (isset($_POST['txtNombre']))? $_POST['txtNombre'] : NULL;
$FechaInicioDesde = (isset($_POST['txtFechaInicioDesde']))? $_POST['txtFechaInicioDesde'] : NULL;
$FechaInicioHasta = (isset($_POST['txtFechaInicioHasta']))? $_POST['txtFechaInicioHasta'] : NULL;


$query = "SELECT DISTINCT 
                usu.usu_id,
                usu.usu_nombre, 
                usu.usu_apellido,
                usu.usu_telefono,
                usu.usu_rut,
                usu.usu_correo
        FROM tsg_usuario usu
        WHERE 
            usu.usu_activo = 1";

if($Rut != null && strlen($Rut) > 0){
	$query .= " AND usu.usu_rut = '$Rut'";
}
if($Nombre != null && strlen($Nombre) > 0){
	$query .= " AND usu.usu_nombre LIKE '%$Nombre%'";
}


if($FechaInicioDesde != null && strlen($FechaInicioDesde) > 0){
	$query .= " AND usu.usu_fecha_crea >= STR_TO_DATE('$FechaInicioDesde','%d-%m-%Y')";
}
if($FechaInicioHasta != null && strlen($FechaInicioHasta) > 0){
	$query .= " AND usu.usu_fecha_crea <= STR_TO_DATE('$FechaInicioHasta','%d-%m-%Y')";
}

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
                            $row['usu_rut'],
                            $row['usu_nombre'],
                            $row['usu_apellido'],
                            $row['usu_correo'],
                            $row['usu_telefono'],
                            "<a class=\"btn\" href=\"javascript:ModificarUsuario(".$row["usu_id"].");\"><i class=\"icon-pencil\"></i></a>"
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
    $_SESSION["BP-Query"] = $query;
	$_SESSION["BP-Post"] = $_POST;
}
        
echo json_encode($aa);

?>