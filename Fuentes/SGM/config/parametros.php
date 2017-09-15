<?php
@session_start();
error_reporting(FALSE);

/* Archivo de configuracion */
// $url = "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
// http://localhost:8080/sgm-lazos/Proyecto/Fuentes/SGM/index.php
// user 11111111-1 pass:asdf

//$sXmlConfig = "$url/sgm-lazos/Proyecto/Fuentes/SGM/config/Config.xml";
//$sXmlConfig = "Config.xml";
//$xml = simplexml_load_file($sXmlConfig);

/* Variables de base de datos 
$V_HOST = $xml->Host;
$V_USER = $xml->User;
$V_PASS = $xml->Password;
$V_BBDD = $xml->BBDD;*/

$V_LLAVE = "ragnarok";

$V_ACCES_DENIED = "<div class='row-fluid'> 
                       <div class='title span12'>
                          <h1>Usted no cuenta con los permisos para acceder a esta p&aacute;gina</h1>
                       </div>        
                    </div> 
                    <div class='row-fluid'>
                       <div class='span5 offset2'>
                          <center><img src='css/images/acceso_denegado.png' title='logo' alt='logo' style='width:150px;'></center>
                       </div>
                    </div>";

$V_TITULO = "Proyecto SGM";
$V_EXT_VALIDAS = "doc,docx,xls,xlsx,jpg,png,pdf";
$V_MAXIMO_MB = "2";

// PlaceHolders
$V_MSG_PH_TEXT = "Ingrese Texto";
$V_MSG_PH_MAIL = "Ingrese Correo";
$V_MSG_PH_FECHA = "Seleccione";
$V_MSG_PH_NUMERO = "Ingrese Número";
$V_MSG_PH_RUT = "Ingrese Rut";
$V_MSG_PH_PASS = "Ingrese Contraseña"; 

// Estadistica
$V_YD = 10;
$V_YH = 20;
$V_GD = 0;
$V_GH = 10;
$V_RD = 20;
$V_RH = 30;
$V_MX = 30;

/* Ambiente testing */

$V_HOST = "mysql.hostinger.es";
$V_USER = "u643183889_sgm";
$V_PASS = "sgmlazos";
$V_BBDD = "u643183889_sgm";

$V_HOST_SMTP = "mx1.hostinger.es";
$V_PORT_SMTP = 2525;
$V_USER_SMTP = "admin@sgm-lazos.esy.es";
$V_PASS_SMTP = "sgmlazos";
$V_FROM      = "noreply@sgm-lazos.esy.es";
$V_FROM_NAME = "SGM-Lazos";

$V_DEPURAR = FALSE;


/* Ambiente desarrollo 
$V_HOST = "localhost";
$V_USER = "sgm";
$V_PASS = "sgm";
$V_BBDD = "sgm";

$V_HOST_SMTP = "mx1.hostinger.es";
$V_PORT_SMTP = 2525;
$V_USER_SMTP = "admin@sgm-lazos.esy.es";
$V_PASS_SMTP = "sgmlazos";
$V_FROM      = "noreply@sgm-lazos.esy.es";
$V_FROM_NAME = "SGM-Lazos";

$V_DEPURAR = TRUE; */
 

require_once("comunes.php");


// http://silviomoreto.github.io/bootstrap-select/
// http://eternicode.github.io/bootstrap-datepicker/
// http://bootboxjs.com/
// https://github.com/PHPMailer/PHPMailer
// https://developers.google.com/chart/?hl=es
// http://www161.lunapic.com/editor/
// http://mattkersley.com/responsive/


?>