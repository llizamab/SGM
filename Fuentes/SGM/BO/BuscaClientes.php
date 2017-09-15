<?php
require("../config/parametros.php");
//http://localhost:8080/sgm-lazos/Proyecto/Fuentes/SGM/BO/BuscaUsuarios.php

$aaData = array();

$Rut = (isset($_POST['txtRut']))? $_POST['txtRut'] : NULL;
$Nombre = (isset($_POST['txtNombre']))? $_POST['txtNombre'] : NULL;
$Apellido = (isset($_POST['txtApellido']))? $_POST['txtApellido'] : NULL;
$Empresa = (isset($_POST['txtEmpresa']))? $_POST['txtEmpresa'] : NULL;
$FechaInicioDesde = (isset($_POST['txtFechaInicioDesde']))? $_POST['txtFechaInicioDesde'] : NULL;
$FechaInicioHasta = (isset($_POST['txtFechaInicioHasta']))? $_POST['txtFechaInicioHasta'] : NULL;


$query = "SELECT DISTINCT 
                cli_id,
                cli_nombre, 
                cli_apellido,
                cli_correo,
                cli_empresa,
                cli_rut
    	  FROM tsg_cliente
          WHERE 
                cli_activo = 1";

if($Rut != null && strlen($Rut) > 0){
	$query .= " AND cli_rut = '$Rut'";
}
if($Nombre != null && strlen($Nombre) > 0){
	$query .= " AND cli_nombre LIKE '%$Nombre%'";
}
if($Apellido != null && strlen($Apellido) > 0){
	$query .= " AND cli_apellido LIKE '%$Apellido%'";
}
if($Empresa != null && strlen($Empresa) > 0){
	$query .= " AND cli_empresa LIKE '%$Empresa%'";
}

if($FechaInicioDesde != null && strlen($FechaInicioDesde) > 0){
	$query .= " AND cli_fecha_ini >= STR_TO_DATE('$FechaInicioDesde','%d-%m-%Y')";
}
if($FechaInicioHasta != null && strlen($FechaInicioHasta) > 0){
	$query .= " AND cli_fecha_ini <= STR_TO_DATE('$FechaInicioHasta','%d-%m-%Y')";
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
                            $row['cli_rut'],
                            $row['cli_nombre'],
                            $row['cli_apellido'],
                            $row['cli_correo'],
                            $row['cli_empresa'],
                            "<a class=\"btn\" href=\"javascript:ModificarCliente(".$row["cli_id"].");\"><i class=\"icon-pencil\"></i></a>"
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