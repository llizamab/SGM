<?php
require("../config/parametros.php");
//http://localhost:8080/sgm-lazos/Proyecto/Fuentes/SGM/BO/BuscaSolicitudes.php

$aaData = array();

$txtCodigoSolicitud = (isset($_POST['txtCodigoSolicitud']))? $_POST['txtCodigoSolicitud'] : NULL;
$txtNombreSolicitud = (isset($_POST['txtNombreSolicitud']))? $_POST['txtNombreSolicitud'] : NULL;
$txtFechaInicioDesde = (isset($_POST['txtFechaInicioDesde']))? $_POST['txtFechaInicioDesde'] : NULL;
$txtFechaInicioHasta = (isset($_POST['txtFechaInicioHasta']))? $_POST['txtFechaInicioHasta'] : NULL;
$ddlProyecto = (isset($_POST['ddlProyecto']))? $_POST['ddlProyecto'] : NULL;
$ddlEstadoSolicitud = (isset($_POST['ddlEstadoSolicitud']))? $_POST['ddlEstadoSolicitud'] : NULL;
$ddlDestacado = (isset($_POST['ddlDestacado']))? $_POST['ddlDestacado'] : NULL;
$ddlPrioridad = (isset($_POST['ddlPrioridad']))? $_POST['ddlPrioridad'] : NULL;
$ddlCategoria = (isset($_POST['ddlCategoria']))? $_POST['ddlCategoria'] : NULL;
$ddlUsuario = (isset($_POST['ddlUsuario']))? $_POST['ddlUsuario'] : NULL;
$ddlCliente = (isset($_POST['ddlCliente']))? $_POST['ddlCliente'] : NULL;
$hdnIdUsuario = (isset($_POST['hdnIdUsuario']))? $_POST['hdnIdUsuario'] : NULL;

$roles = $_SESSION['roles'];

if(is_array($roles) && count($roles) == 1 && $roles[4] != ""){
    $hdnIdUsuario = $_SESSION['id_usuario'];
}


$query = "SELECT DISTINCT 
				tick.tic_destcado,
				tick.tic_id,
				tick.tic_nombre,
				est_tick.est_nombre,
                pry.pro_nombre,
                cat.cat_nombre,
                prio.pri_nombre,
                clie.cli_empresa,
                usu.usu_nombre,
                usu.usu_rut
        FROM tsg_ticket tick
        	LEFT JOIN tsg_estado_ticket est_tick
        	ON tick.tsg_estado_ticketest_id = est_tick.est_id AND est_tick.est_activo = 1
			
			LEFT JOIN tsg_proyecto pry
			ON tick.tsg_proyectopro_id = pry.pro_id AND pry.pro_activo = 1
			
			LEFT JOIN tsg_cliente clie
			ON pry.tsg_clientecli_id = clie.cli_id
        	
        	LEFT JOIN tsg_categoria cat
        	ON tick.tsg_categoriacat_id = cat.cat_id
        	
        	LEFT JOIN tsg_prioridad prio
        	ON tick.tsg_prioridadpri_id = prio.pri_id
        	
        	LEFT JOIN tsg_usuario usu
        	ON tick.tsg_usuariousu_id = usu.usu_id
        WHERE 
            1 = 1";

// Búsqueda por las asignadas al usuario en sesión
if($hdnIdUsuario != NULL && strlen($hdnIdUsuario) > 0)
{
	$query .= " AND tick.tsg_usuariousu_id = $hdnIdUsuario 
	            OR EXISTS ( SELECT 1 
							FROM tsg_historico_ticket his
						   WHERE his.tsg_tickettic_id = tick.tic_id
						         AND his.tsg_usuariousu_id = $hdnIdUsuario ) ";
}
else // Búsqueda normal
{

	if($txtCodigoSolicitud != null && strlen($txtCodigoSolicitud) > 0){
		$query .= " AND tick.tic_id = $txtCodigoSolicitud";
	}
	if($txtNombreSolicitud != null && strlen($txtNombreSolicitud) > 0){
		$query .= " AND tick.tic_nombre LIKE '%$txtNombreSolicitud%'";
	}
	if($ddlProyecto != null && is_array($ddlProyecto) && count($ddlProyecto) > 0)
	{
		$query .= " AND tick.tsg_proyectopro_id IN (";
		foreach($ddlProyecto as $obj){
			$query .= "$obj,";
		}
		$query = substr($query,0, -1).")";
	}
	if($ddlEstadoSolicitud != null && is_array($ddlEstadoSolicitud) && count($ddlEstadoSolicitud) > 0)
	{
		$query .= " AND tick.tsg_estado_ticketest_id IN (";
		foreach($ddlEstadoSolicitud as $obj){
			$query .= "$obj,";
		}
		$query = substr($query,0, -1).")";
	}
	if($ddlDestacado != null && strlen($ddlDestacado) > 0 && $ddlDestacado != "-1"){
		$query .= " AND tick.tic_destcado = $ddlDestacado";
	}
	if($ddlPrioridad != null && is_array($ddlPrioridad) && count($ddlPrioridad) > 0)
	{
		$query .= " AND tick.tsg_prioridadpri_id IN (";
		foreach($ddlPrioridad as $obj){
			$query .= "$obj,";
		}
		$query = substr($query,0, -1).")";
	}
	if($ddlCategoria != null && is_array($ddlCategoria) && count($ddlCategoria) > 0)
	{
		$query .= " AND tick.tsg_categoriacat_id IN (";
		foreach($ddlCategoria as $obj){
			$query .= "$obj,";
		}
		$query = substr($query,0, -1).")";
	}
	if($ddlUsuario != null && is_array($ddlUsuario) && count($ddlUsuario) > 0)
	{
		$query .= " AND tick.tsg_usuariousu_id IN (";
		foreach($ddlUsuario as $obj){
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
	if($txtFechaInicioDesde != null && strlen($txtFechaInicioDesde) > 0){
		$query .= " AND tick.tic_fecha_crea >= STR_TO_DATE('$txtFechaInicioDesde','%d-%m-%Y')";
	}
	if($txtFechaInicioHasta != null && strlen($txtFechaInicioHasta) > 0){
		$query .= " AND tick.tic_fecha_crea <= STR_TO_DATE('$txtFechaInicioHasta','%d-%m-%Y')";
	}
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
    $destIni = "<a class=\"btn\" href=\"javascript:NoDestacarSolicitud(";
    $destFin = ");\"><i class=\"icon-star\"";
    $ndestIni = "<a class=\"btn\" href=\"javascript:DestacarSolicitud(";
    $ndestFin = ");\"><i class=\"icon-star-empty\"";
    while($row = $res->fetch_assoc())
    {
        $aaData[] = array(  
                            ($row["tic_destcado"] == "1") ? 
                            	$destIni.$row["tic_id"].$destFin." id='fila".$row['tic_id']."' value=\"1\" ></i></a>" 
								: 
								$ndestIni.$row["tic_id"].$ndestFin." id='fila".$row['tic_id']."' value=\"0\" ></i></a>",
                            $row['tic_id'],
                            $row['tic_nombre'],
                            $row['est_nombre'],
                            $row['pro_nombre'],
                            $row['cli_empresa'],
                            $row['cat_nombre'],
                            $row['pri_nombre'],
                            $row['usu_rut']." - ".$row['usu_nombre'],
                            
                            "<a class=\"btn\" href=\"javascript:ModificarSolicitud(".$row["tic_id"].");\"><i class=\"icon-pencil\"></i></a>"
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