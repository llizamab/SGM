<?php

function generar_clave($longitud){ 
       $cadena="[^A-Z0-9]"; 
       return substr(preg_replace($cadena, "", md5(rand())) . 
       preg_replace($cadena, "", md5(rand())) . 
       preg_replace($cadena, "", md5(rand())), 
       0, $longitud); 
} 

function generar_Hash($clave, $llave)
{
	//$salt = "$2a$07$" + $llave + "$";
	//return crypt($clave, $salt);

	return md5($clave);
}


function ValidaAcceso($pagina, $datos){
    
    foreach ($datos as $titulo => $opciones) 
    {
      foreach ($opciones as $grupo) 
      {
          foreach ($grupo as $opcion) 
          {
              if(strpos($opcion['RUTA'], $pagina) !== FALSE)
              {
                  return TRUE;
              } 
          }
      }
    }
    return FALSE;
}

function debug($var){
    $msg = "<span>".var_dump($var)."</span>";
    return $msg;
}



// Clase para generar cosas genericas
class Utilidades
{
    private $V_HOST;
    private $V_USER;
    private $V_PASS;
    private $V_BBDD;
    
    function __construct($V_HOST="localhost", $V_USER="sgm", $V_PASS="sgm", $V_BBDD="sgm")
    {
        $this->V_HOST=$V_HOST;
        $this->V_USER=$V_USER;
        $this->V_PASS=$V_PASS;
        $this->V_BBDD=$V_BBDD;
    }
    
    public function GeneraSelectClientes($nombre, $multiple = false, $buscar = false, $size = 0){
            
        $html  = "<label>Cliente</label>";
        if($multiple)
        {
            $html  = "<label>Clientes</label>";
        }
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT `cli_id`, `cli_empresa`, `cli_rut` FROM `tsg_cliente` WHERE `cli_activo` = 1 ";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["cli_id"]."'>".$row["cli_rut"]." - ".$row["cli_empresa"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }
    
    public function GeneraSelectDestacado($nombre){
        $html  = "<label>Destacado</label>";
        $html .= "<select class=\"selectpicker\" name=\"$nombre\" id=\"$nombre\" data-size=\"3\" data-live-search=\"false\">";
        $html .= "<option data-icon=\"icon-list\" value='-1' selected >Seleccione...</option>";
        $html .= "<option data-icon=\"icon-star\" value='1'>Destacados</option>";
        $html .= "<option data-icon=\"icon-star-empty\" value='0'>No Destacados</option>";
        $html .= "</select>";

        return $html;
    }
    
    public function GeneraSelectTipoProyecto($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Tipo Proyecto</label>";
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT `tip_id`, `tip_nombre` FROM `sqi_tipo_proyecto` WHERE `tip_activo` = 1 ";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["tip_id"]."'>".$row["tip_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }
    
    public function GeneraSelectJefeProyecto($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Jefe de Proyecto</label>";
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT DISTINCT usu.usu_id, usu.usu_nombre, usu.usu_apellido
                    FROM tsg_usuario usu
                    INNER JOIN tsg_proyecto pry
                    ON pry.pro_usu_id_jefepro = usu.usu_id
                    WHERE usu.usu_activo = 1 AND pry.pro_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["usu_id"]."'>".$row["usu_nombre"]." ".$row["usu_apellido"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectEncargado($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Encargado</label>";
        if($multiple)
        {
            $html  = "<label>Encargados</label>";
        }
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        $id_Encargado = 3; // Rol encargado
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT DISTINCT usu.usu_id, usu.usu_nombre, usu.usu_apellido
                  FROM tsg_usuario usu
                    INNER JOIN tsg_usuario_tsg_rol rol_usu
                    ON rol_usu.tsg_usuariousu_id = usu.usu_id
                    INNER JOIN tsg_rol rol
                    ON rol.rol_id = rol_usu.tsg_rolrol_id AND rol.rol_activo = 1
                  WHERE usu.usu_activo = 1 AND rol.rol_id = $id_Encargado ";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["usu_id"]."'>".$row["usu_nombre"]." ".$row["usu_apellido"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectEstadoProyecto($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Estado Proyecto</label>";
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT est_id, est_nombre
                    FROM tsg_estado_proyecto 
                    WHERE est_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["est_id"]."'>".$row["est_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectProyectos($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Proyecto</label>";
        if($multiple)
        {
            $html  = "<label>Proyectos</label>";
        }
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT pro_id, pro_nombre
                    FROM tsg_proyecto 
                    WHERE pro_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["pro_id"]."'>".$row["pro_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectEstadoSolicitud($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Estado Solicitud</label>";
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT est_id, est_nombre
                    FROM tsg_estado_ticket 
                    WHERE est_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["est_id"]."'>".$row["est_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectCategoriaSolicitud($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Categoría Solicitud</label>";
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT cat_id, cat_nombre
                    FROM tsg_categoria 
                    WHERE cat_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["cat_id"]."'>".$row["cat_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }
    
    public function GeneraSelectUsuarios($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Usuario</label>";
        if($multiple)
        {
            $html  = "<label>Usuarios</label>";
        }
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT usu_id, usu_rut,usu_nombre
                    FROM tsg_usuario 
                    WHERE usu_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["usu_id"]."'>".$row["usu_rut"]." - ".$row["usu_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function GeneraSelectPrioridad($nombre, $multiple = false, $buscar = false, $size = 0){
        $html  = "<label>Prioridad</label>";
        if($multiple)
        {
            $html  = "<label>Prioridades</label>";
        }
        $html .= "<select class=\"selectpicker\" id=\"$nombre\" name=\"$nombre";
        
        if($multiple == true){
            $html .= "[]\"  multiple "; 
        }
        else{
            $html .= "\" ";
        }
        
        if($buscar == true){
            $html .= " data-live-search=\"true\" "; 
        }
        
        if($size != 0)
        {
            $html .= " data-size=\"$size\"  ";
        }
        
        $html .= ">";
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT pri_id, pri_nombre
                    FROM tsg_prioridad 
                    WHERE pri_activo = 1";

        if ($mySqli -> connect_errno) {
            $html = "Error al generar el menu";
            return $html;
        }
        $res = $mySqli -> query($query);

        if ($mySqli -> affected_rows > 0) {
            while ($row = $res -> fetch_assoc()) {
                $html .= "<option value='".$row["pri_id"]."'>".$row["pri_nombre"]."</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }
    
    public function toString()
    {
        return var_dump($this);
    }
};

class EnvioMail
{
    private $Host;
    private $Port;
    private $SMTPAuth;
    private $Username;
    private $Password;
    private $From;
    private $FromName;
    private $mail;
    private $V_HOST;
    private $V_USER;
    private $V_PASS;
    private $V_BBDD;
    public  $ErrorInfo;
    
    function __construct($Host,$Port,$Username,$Password,$From,$FromName,$V_HOST, $V_USER, $V_PASS, $V_BBDD)
    {
        require('../mail/PHPMailerAutoload.php');
        
        $this->Host=$Host;
        $this->Port=$Port;
        $this->Username=$Username;
        $this->Password=$Password;
        $this->From=$From;
        $this->FromName=$FromName;
        
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->Host = $this->Host;
        $this->mail->Port = $this->Port;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->Username;
        $this->mail->Password = $this->Password;
        
        $this->mail->From = $this->From;
        $this->mail->FromName = $this->FromName;
        $this->mail->WordWrap = 50;   
        $this->mail->isHTML(true);
        
        $this->V_HOST=$V_HOST;
        $this->V_USER=$V_USER;
        $this->V_PASS=$V_PASS;
        $this->V_BBDD=$V_BBDD;
    }
    
    public function EnviarCorreo($Asunto, $Cuerpo, $Para, $CC = null, $BC = null, $CuerpoAlt = ""){
        
        try
        {
            if(is_array($Para)){
                foreach ($Para as $key => $value) {
                    $this->mail->addAddress($key, $value);
                }
            }
            if($CC != null && is_array($CC)){
                foreach ($CC as $key => $value) {
                    $this->mail->addCC($key, $value);
                }
            }
            if($BC != null && is_array($BC)){
                foreach ($BC as $key => $value) {
                    $this->mail->addBCC($key, $value);
                }
            }
            
            $this->mail->Subject = $Asunto;
            $this->mail->Body    = $Cuerpo;
            $this->mail->AltBody = $CuerpoAlt;
            
            if($this->mail->send()) {
               return TRUE;
            }
            else{
                $this->ErrorInfo = $this->mail->ErrorInfo;
                return FALSE;
            }
        }
        catch(exception $e)
        {
            $this->ErrorInfo = $e->getMessage();
            return FALSE;
        }
    }

    public function enviarCorreoCreacionSolicitud($idSolicitud){
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT
                        tick.tic_nombre,
                        tick.tic_descripcion,
                        tick.tsg_tic_correo_en_copia,
                        est_tick.est_nombre,
                        pry.pro_nombre,
                        cat.cat_nombre,
                        prio.pri_nombre,
                        clie.cli_empresa,
                        usu.usu_nombre,
                        usu.usu_correo
                FROM tsg_ticket tick
                    INNER JOIN tsg_estado_ticket est_tick
                    ON tick.tsg_estado_ticketest_id = est_tick.est_id AND est_tick.est_activo = 1
                    
                    INNER JOIN tsg_proyecto pry
                    ON tick.tsg_proyectopro_id = pry.pro_id AND pry.pro_activo = 1
                    
                    INNER JOIN tsg_cliente clie
                    ON pry.tsg_clientecli_id = clie.cli_id
                    
                    INNER JOIN tsg_categoria cat
                    ON tick.tsg_categoriacat_id = cat.cat_id
                    
                    INNER JOIN tsg_prioridad prio
                    ON tick.tsg_prioridadpri_id = prio.pri_id
                    
                    INNER JOIN tsg_usuario usu
                    ON tick.tsg_usuariousu_id = usu.usu_id
                WHERE 
                    tick.tic_id = $idSolicitud ";

        if ($mySqli->connect_errno) {
            return FALSE;
        }
        
        $res = $mySqli->query($query);

        if ($mySqli->affected_rows > 0) {
            while ($row = $res->fetch_assoc()) {

                $pry = $row["pro_nombre"];
                $tipo = $row["cat_nombre"];
                $estado = $row["est_nombre"];
                $user = $row["usu_nombre"];
                $nombre = $row["tic_nombre"];
                $desc = $row["tic_descripcion"];
                $correo = array($row["usu_correo"] => $row["usu_nombre"]);
                $copia = $row["tsg_tic_correo_en_copia"];
                $priori = $row["pri_nombre"];
            }
        }
        
        $subject = "Se ha creado la solicitud $idSolicitud";
        
        $body = "<h4>Estimados(as):</h4>
                  <p>Con fecha ".date("d-M-Y H:m:s")." se ha creado 
                  exitosamente la solicitud <b>$idSolicitud</b> con el siguiente detalle:</p>
                  <br>
                  <ul>
                      <li>Proyecto: $pry</li>
                      <li>Tipo: $tipo</li>
                      <li>Prioridad: $priori</li>
                      <li>Estado: $estado</li>
                      <li>Usuario creador: $user</li>
                      <li>Nombre: $nombre</li>
                      <li>Descripci&oacute;n: $desc</li>
                  </ul>
                  <br>
                  <h5>Proyecto SGM</h5>
                  <small>Mensaje generado autom&aacute;ticamente</small>";
        
        if(strlen($copia) > 0)
        {
            $copia = preg_split('/;/', $copia);
            $copia_aux = array();
            
            foreach ($copia as $obj) {
                $copia_aux[$obj] = $obj;
            }
            $copia = $copia_aux;
        }
        else{
            $copia = NULL;
        }
        
        // remover
        $BC = array("luis.lizama05@inacapmail.cl" => "Luxo lizama");

        $this->EnviarCorreo($subject, $body, $correo, $copia, $BC);
    }
    
    public function enviarCorreoModificacionSolicitud($idSolicitud){
        
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);
        $query = "SELECT
                        tick.tic_nombre,
                        tick.tic_descripcion,
                        tick.tsg_tic_correo_en_copia,
                        clie.cli_empresa,
                        pry.pro_nombre,
                        
                        est_tick_h.est_nombre AS est_nombre_anterior,
                        est_tick.est_nombre   AS est_nombre_actual,
                        
                        cat_h.cat_nombre AS cat_nombre_anterior,
                        cat.cat_nombre   AS cat_nombre_actual,
                        
                        prio_h.pri_nombre AS pri_nombre_anterior,
                        prio.pri_nombre   AS pri_nombre_actual,
                        
                        usu_h.usu_nombre  AS usu_nombre_anterior,
                        usu.usu_nombre    AS usu_nombre_actual,
                        
                        usu_h.usu_correo  AS usu_correo_anterior,
                        usu.usu_correo    AS usu_correo_actual
                        
                FROM tsg_ticket tick
                    INNER JOIN tsg_estado_ticket est_tick
                    ON tick.tsg_estado_ticketest_id = est_tick.est_id AND est_tick.est_activo = 1
                    
                    INNER JOIN tsg_proyecto pry
                    ON tick.tsg_proyectopro_id = pry.pro_id AND pry.pro_activo = 1
                    
                    INNER JOIN tsg_cliente clie
                    ON pry.tsg_clientecli_id = clie.cli_id
                    
                    INNER JOIN tsg_categoria cat
                    ON tick.tsg_categoriacat_id = cat.cat_id
                    
                    INNER JOIN tsg_prioridad prio
                    ON tick.tsg_prioridadpri_id = prio.pri_id
                    
                    INNER JOIN tsg_usuario usu
                    ON tick.tsg_usuariousu_id = usu.usu_id
                    
                    LEFT JOIN tsg_historico_ticket his_tick
                    ON his_tick.tsg_tickettic_id = tick.tic_id 
                        AND his_tick.his_id = (SELECT t.his_id FROM 
                                               tsg_historico_ticket t
                                               WHERE t.tsg_tickettic_id = tick.tic_id
                                               ORDER BY t.his_id DESC
                                               LIMIT 1)
                    INNER JOIN tsg_estado_ticket est_tick_h
                    ON his_tick.tsg_estado_ticketest_id = est_tick_h.est_id   
                    
                    INNER JOIN tsg_categoria cat_h
                    ON his_tick.tsg_categoriacat_id = cat_h.cat_id
                    
                    INNER JOIN tsg_prioridad prio_h
                    ON his_tick.tsg_prioridadpri_id = prio_h.pri_id
                    
                    INNER JOIN tsg_usuario usu_h
                    ON his_tick.tsg_usuariousu_id = usu_h.usu_id                    
                                               
                WHERE 
                    tick.tic_id = $idSolicitud ";

        if ($mySqli->connect_errno) {
            return FALSE;
        }
        
        $res = $mySqli->query($query);

        if ($mySqli->affected_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                        
                $subject = "Se ha modificado la solicitud $idSolicitud";
                $pry = $row["pro_nombre"];
                $nombre = $row["tic_nombre"];
                $desc = $row["tic_descripcion"];
                $copia = $row["tsg_tic_correo_en_copia"];
                
                $estado_anterior = $row["est_nombre_anterior"];
                $estado_actual = $row["est_nombre_actual"];
                
                $tipo_anterior = $row["cat_nombre_anterior"];
                $tipo_actual = $row["cat_nombre_actual"];
                
                $user_anterior = $row["usu_nombre_anterior"];
                $user_actual = $row["usu_nombre_actual"];
                
                $correo_anterior = array($row["usu_correo_anterior"] => $row["usu_nombre_anterior"]);
                $correo_actual = array($row["usu_correo_actual"] => $row["usu_nombre_actual"]);
                
                $priori_anterior = $row["pri_nombre_anterior"];
                $priori_actual = $row["pri_nombre_actual"];
            }
        }
        
        $body = "<h4>Estimados(as):</h4>
                  <p>Con fecha ".date("d-M-Y H:m:s")." se ha modificado 
                  exitosamente la solicitud <b>$idSolicitud</b> con el siguiente detalle:</p>
                  <br>
                  <ul>
                      <li>Proyecto: $pry</li>";
                      
        if($tipo_anterior != $priori_actual)
        {
            $body .= "<li>Tipo: De $tipo_anterior a $tipo_actual</li>";
        }
        else
        {
            $body .= "<li>Tipo: $tipo_anterior</li>";
        }
                      
        if($priori_anterior != $priori_actual)
        {
            $body .= "<li>Prioridad: De $priori_anterior a $priori_actual</li>";
        }
        else
        {
            $body .= "<li>Prioridad: $priori_anterior</li>";
        }
        
        if($estado_anterior != $estado_actual)
        {
            $body .= "<li>Estado: De $estado_anterior a $estado_actual</li>";
        }
        else
        {
            $body .= "<li>Estado: $estado_anterior</li>";
        }
        
        if($user_anterior != $user_actual)
        {
            $body .= "<li>Usuario: De $user_anterior a $user_actual</li>";
        }
        else
        {
            $body .= "<li>Usuario: $user_anterior</li>";
        }
        
        
            $body .= "<li>Nombre: $nombre</li>
                      <li>Descripci&oacute;n: $desc</li>
                  </ul>
                  <br>
                  <h5>Proyecto SGM</h5>
                  <small>Mensaje generado autom&aacute;ticamente</small>";
        
        if(strlen($copia) > 0)
        {
            $copia = preg_split('/;/', $copia);
            $copia_aux = array();
            
            foreach ($copia as $obj) {
                $copia_aux[$obj] = $obj;
            }
            $copia = $copia_aux;
        }
        else{
            $copia = NULL;
        }
        
        $correo = array_merge($correo_anterior, $correo_actual);
        
        // remover
        $BC = array("luis.lizama05@inacapmail.cl" => "Luxo lizama");

        $this->EnviarCorreo($subject, $body, $correo, $copia, $BC);
    }
    
    public function toString()
    {
        return var_dump($this);
    }
};

class RegistraEstadistica
{
    private $V_HOST;
    private $V_USER;
    private $V_PASS;
    private $V_BBDD;
    
    function __construct($V_HOST, $V_USER, $V_PASS, $V_BBDD)
    {
        $this->V_HOST=$V_HOST;
        $this->V_USER=$V_USER;
        $this->V_PASS=$V_PASS;
        $this->V_BBDD=$V_BBDD;
    }
    
    public function RegistraEstadistica($idEstado, $idProyecto)
    {
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);

        if ($mySqli->connect_errno) {
            $html = "$mySqli->error";
            return $html;
        }
        
        $query = "SELECT 1 FROM tsg_estadistica_diaria 
                  WHERE dis_fecha = CURDATE() AND tsg_proyectopro_id = $idProyecto;";
        
        $res = $mySqli->query($query);

        if ($mySqli->affected_rows > 0) { // update
           
            $query = "UPDATE tsg_estadistica_diaria SET dis_total = dis_total + 1,";
            
            switch($idEstado)
            {
                case "1":
                    $query .= "dis_creadas = dis_creadas + 1 ";
                    break;
                case "2":
                    $query .= "dis_asignadas = dis_asignadas + 1 ";
                    break;
                case "3":
                    $query .= "dis_resueltas = dis_resueltas + 1 ";
                    break;
                case "4":
                    $query .= "dis_rechazadas = dis_rechazadas + 1 ";
                    break;
                case "5":
                    $query .= "dis_cerradas = dis_cerradas + 1 ";
                    break;
                case "6":
                    $query .= "dis_desestimadas = dis_desestimadas + 1 ";
                    break;
            }
            
            $query .= " WHERE dis_fecha = CURDATE() AND tsg_proyectopro_id = $idProyecto;";
            
            $res = $mySqli -> query($query);
            $mySqli->commit();
            $mySqli->close();
        }
        else // Insert
        {
            $query = "INSERT INTO tsg_estadistica_diaria (dis_fecha,dis_total,dis_creadas,dis_asignadas,dis_resueltas,dis_rechazadas,dis_cerradas,dis_desestimadas,tsg_proyectopro_id) 
                      VALUES (CURDATE(),1,";

            switch($idEstado)
            {
                case "1":
                    $query .= "1,0,0,0,0,0,$idProyecto);";
                    break;
                case "2":
                    $query .= "0,1,0,0,0,0,$idProyecto);";
                    break;
                case "3":
                    $query .= "0,0,1,0,0,0,$idProyecto);";
                    break;
                case "4":
                    $query .= "0,0,0,1,0,0,$idProyecto);";
                    break;
                case "5":
                    $query .= "0,0,0,0,1,0,$idProyecto);";
                    break;
                case "6":
                    $query .= "0,0,0,0,0,1,$idProyecto);";
                    break;
            }
            $res = $mySqli -> query($query);
            $mySqli->commit();
            $mySqli->close();
        }  
    }
    
    public function IniciaEstadistica($idProyecto)
    {
        $mySqli = new mysqli($this->V_HOST, $this->V_USER, $this->V_PASS, $this->V_BBDD);

        if ($mySqli->connect_errno) {
            $html = "$mySqli->error";
            return $html;
        }
        $query = "INSERT INTO tsg_estadistica_diaria (dis_fecha,dis_total,dis_creadas,dis_asignadas,dis_resueltas,dis_rechazadas,dis_cerradas,dis_desestimadas,tsg_proyectopro_id) 
                      VALUES (CURDATE(),0,0,0,0,0,0,0,$idProyecto);";
        
        $res = $mySqli->query($query);

        if ($mySqli->affected_rows > 0) {
            $mySqli->commit();
            $mySqli->close();
        }
    }
    
    public function toString()
    {
        return var_dump($this);
    }
};

?>