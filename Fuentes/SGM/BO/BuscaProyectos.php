<?php
require("../config/parametros.php");
//http://localhost:8080/sgm-lazos/Proyecto/Fuentes/SGM/BO/BuscaRegistros.php

$aaData = array();

$CodigoProyecto = (isset($_POST['txtCodigoProyecto']))? $_POST['txtCodigoProyecto'] : NULL;
$NombreProyecto = (isset($_POST['txtNombreProyecto']))? $_POST['txtNombreProyecto'] : NULL;
$ddlJefeProyecto = (isset($_POST['ddlJefeProyecto']))? $_POST['ddlJefeProyecto'] : NULL;
$ddlCliente = (isset($_POST['ddlCliente']))? $_POST['ddlCliente'] : NULL;
$FechaInicioDesde = (isset($_POST['txtFechaInicioDesde']))? $_POST['txtFechaInicioDesde'] : NULL;
$FechaTerminoDesde = (isset($_POST['txtFechaTerminoDesde']))? $_POST['txtFechaTerminoDesde'] : NULL;
$FechaGarantiaDesde = (isset($_POST['txtFechaGarantiaDesde']))? $_POST['txtFechaGarantiaDesde'] : NULL;
$ddlDestacado = (isset($_POST['ddlDestacado']))? $_POST['ddlDestacado'] : NULL;
$FechaInicioHasta = (isset($_POST['txtFechaInicioHasta']))? $_POST['txtFechaInicioHasta'] : NULL;
$FechaTerminoHasta = (isset($_POST['txtFechaTerminoHasta']))? $_POST['txtFechaTerminoHasta'] : NULL;
$FechaGarantiaHasta = (isset($_POST['txtFechaGarantiaHasta']))? $_POST['txtFechaGarantiaHasta'] : NULL;
$ddlTipoProyecto = (isset($_POST['ddlTipoProyecto']))? $_POST['ddlTipoProyecto'] : NULL;
$ddlEstadoProyecto = (isset($_POST['ddlEstadoProyecto']))? $_POST['ddlEstadoProyecto'] : NULL;

$query = "SELECT DISTINCT 
                pry.pro_destacado,
                pry.pro_id,
                pry.pro_nombre,
                tip_pry.tip_nombre,
                est_pry.est_nombre,
                DATE_FORMAT(pry.pro_fecha_ini,'%d-%m-%Y') AS pro_fecha_ini,
                DATE_FORMAT(pry.pro_fecha_term,'%d-%m-%Y') AS pro_fecha_term,
                DATE_FORMAT(pry.pro_fecha_garan,'%d-%m-%Y') AS pro_fecha_garan,
                cli.cli_rut
                
        FROM tsg_proyecto pry
            
            LEFT JOIN sqi_tipo_proyecto tip_pry
            ON pry.sqi_tipo_proyectotip_id = tip_pry.tip_id AND tip_activo = 1
            
            LEFT JOIN tsg_estado_proyecto est_pry
            ON pry.tsg_estado_proyectoest_id = est_pry.est_id AND est_pry.est_activo = 1
            
            LEFT JOIN tsg_cliente cli 
            ON pry.tsg_clientecli_id = cli.cli_id AND cli_activo = 1
            
        WHERE 
            pry.pro_activo = 1";

if($CodigoProyecto != null && strlen($CodigoProyecto) > 0){
	$query .= " AND pry.pro_id = $CodigoProyecto";
}
if($NombreProyecto != null && strlen($NombreProyecto) > 0){
	$query .= " AND pry.pro_nombre LIKE '%$NombreProyecto%'";
}

if($ddlJefeProyecto != null && is_array($ddlJefeProyecto) && count($ddlJefeProyecto) > 0)
{
	$query .= " AND EXISTS ( SELECT 1 FROM tsg_usuario_tsg_proyecto 
	                         WHERE tsg_proyectopro_id = pry.pro_id 
	                           AND rol_id = 3
	                           AND tsg_usuariousu_id IN (";
	foreach($ddlJefeProyecto as $obj){
		$query .= "$obj,";
	}
	$query = substr($query,0, -1).") )";
	
}

if($ddlCliente != null && is_array($ddlCliente) && count($ddlCliente) > 0)
{
	$query .= " AND pry.tsg_clientecli_id IN (";
	foreach($ddlCliente as $obj){
		$query .= "$obj,";
	}
	$query = substr($query,0, -1).")";
}
if($ddlTipoProyecto != null && is_array($ddlTipoProyecto) && count($ddlTipoProyecto) > 0)
{
	$query .= " AND pry.sqi_tipo_proyectotip_id IN (";
	foreach($ddlTipoProyecto as $obj){
		$query .= "$obj,";
	}
	$query = substr($query,0, -1).")";
}
if($ddlEstadoProyecto != null && is_array($ddlEstadoProyecto) && count($ddlEstadoProyecto) > 0)
{
	$query .= " AND pry.tsg_estado_proyectoest_id IN (";
	foreach($ddlEstadoProyecto as $obj){
		$query .= "$obj,";
	}
	$query = substr($query,0, -1).")";
}
if($ddlDestacado != null && strlen($ddlDestacado) > 0 && $ddlDestacado != "-1"){
	$query .= " AND pry.pro_destacado = $ddlDestacado";
}

if($FechaInicioDesde != null && strlen($FechaInicioDesde) > 0){
	$query .= " AND pry.pro_fecha_ini >= STR_TO_DATE('$FechaInicioDesde','%d-%m-%Y')";
}
if($FechaTerminoDesde != null && strlen($FechaTerminoDesde) > 0){
	$query .= " AND pry.pro_fecha_term >= STR_TO_DATE('$FechaTerminoDesde','%d-%m-%Y')";
}
if($FechaGarantiaDesde != null && strlen($FechaGarantiaDesde) > 0){
	$query .= " AND pry.pro_fecha_garan >= STR_TO_DATE('$FechaGarantiaDesde','%d-%m-%Y')";
}
if($FechaInicioHasta != null && strlen($FechaInicioHasta) > 0){
	$query .= " AND pry.pro_fecha_ini <= STR_TO_DATE('$FechaInicioHasta','%d-%m-%Y')";
}
if($FechaTerminoHasta != null && strlen($FechaTerminoHasta) > 0){
	$query .= " AND pry.pro_fecha_term <= STR_TO_DATE('$FechaTerminoHasta','%d-%m-%Y')";
}
if($FechaGarantiaHasta != null && strlen($FechaGarantiaHasta) > 0){
	$query .= " AND pry.pro_fecha_garan <= STR_TO_DATE('$FechaGarantiaHasta','%d-%m-%Y')";
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
    $destIni = "<a class=\"btn\" href=\"javascript:NoDestacarProyecto(";
    $destFin = ");\"><i class=\"icon-star\"";
    $ndestIni = "<a class=\"btn\" href=\"javascript:DestacarProyecto(";
    $ndestFin = ");\"><i class=\"icon-star-empty\"";
    while($row = $res->fetch_assoc())
    {
        $aaData[] = array(  
                            ($row["pro_destacado"] == "1") ? 
                            	$destIni.$row["pro_id"].$destFin." id='fila".$row['pro_id']."' value=\"1\" ></i></a>" 
								: 
								$ndestIni.$row["pro_id"].$ndestFin." id='fila".$row['pro_id']."' value=\"0\" ></i></a>",
                            $row['pro_id'],
                            $row['pro_nombre'],
                            $row['tip_nombre'],
                            $row['est_nombre'],
                            $row['pro_fecha_ini'],
                            $row['pro_fecha_term'],
                            $row['pro_fecha_garan'],
                            $row['cli_rut'],
                            "<a class=\"btn\" href=\"javascript:ModificarProyecto(".$row["pro_id"].");\"><i class=\"icon-pencil\"></i></a>"
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