
<?php

require_once("config/parametros.php");

$usu_id = $_SESSION["id_usuario"];
// Generar Menu
$query ="SELECT DISTINCT
               modp.mod_nombre  AS TITULO_PADRE,
               modh.mod_nombre  AS TITULO,
               modh.mod_descrip AS RUTA,
               modh.mod_ruta_imagen AS IMAGEN
        FROM tsg_modulo modh
             INNER JOIN tsg_modulo modp
             ON modh.mod_id_mod_padre = modp.mod_id
             
             INNER JOIN tsg_modulo_tsg_rol mod_rol
             ON modh.mod_id = mod_rol.tsg_modulomod_id
             
             INNER JOIN tsg_rol rol
             ON rol.rol_id = mod_rol.tsg_rolrol_id
             
             INNER JOIN tsg_usuario_tsg_rol user_rol
             ON rol.rol_id = user_rol.tsg_rolrol_id
             
             INNER JOIN tsg_usuario usu
             ON usu.usu_id = user_rol.tsg_usuariousu_id
        
        WHERE modh.mod_activo = 1 
          AND modp.mod_activo = 1
          AND rol.rol_activo  = 1
          AND usu.usu_id = $usu_id
        ORDER BY modp.mod_id, modh.mod_id ";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    echo "Error al generar el menu";
}
$res = $mySqli->query($query);
$Menu = array();

if($mySqli->affected_rows > 0)
{
    $x = 0;
    $y = 0;
    $flag = TRUE;
    $titulo = "";
    
    while($row = $res->fetch_assoc())
    {
        if($titulo != $row['TITULO_PADRE']){
            $x = 0;
            $y = 0;
            $flag = TRUE;
        }
        if($flag){
            $titulo = $row['TITULO_PADRE'];
            $flag = FALSE;
        }

        $Menu[$row['TITULO_PADRE']][$x][$y]['TITULO'] = $row['TITULO'];
        $Menu[$row['TITULO_PADRE']][$x][$y]['RUTA'] = $row['RUTA'];
        $Menu[$row['TITULO_PADRE']][$x][$y]['IMAGEN'] = $row['IMAGEN'];

        $y++;
        if($y % 3 == 0){
            $x++;    
        }
    }
  $mySqli->close();
}
else
{
    $Menu["No existen opciones disponibles"] = array();
}

?>

<div class="container-fluid" style="min-height: 490px;">
  <div class="row-fluid">
    <div class="span3">
        <div id="myAccordion" class="accordion">
                
<?php    

$_SESSION['paginas'] = $Menu;
          
$x = 1;
foreach ($Menu as $titulo => $opciones) 
{
  echo "<div class='accordion-group'>
            <div class='accordion-heading'>
                <a href='#collapse$x' data-parent='#myAccordion' data-toggle='collapse' class='accordion-toggle btn-primary'>$titulo</a>
            </div>
            <div class='accordion-body collapse' id='collapse$x'>
                <div class='accordion-inner'>";
                
  foreach ($opciones as $grupo) 
  {
      echo "<div class='container'>
                <div class='row-fluid'>";
      
      foreach ($grupo as $opcion) 
      {
          /*echo "<div class='span1'>
                    <img src='".$opcion['IMAGEN']."' style='width: 55px;height: 55px;' onclick='Ir(\"".$opcion['RUTA']."\");' /><p>".$opcion['TITULO']."</p>
                </div>";*/
                
          echo "<div class='span1'>
                    
                    <img class='btn btn-small' src='".$opcion['IMAGEN']."' style='width: 55px;height: 55px;' onclick='Ir(\"".$opcion['RUTA']."\");' id='".preg_replace("/\\.php$/", "",$opcion['RUTA'])."' />
                    <p> ".$opcion['TITULO']." </p>
                    
                </div>"; 
      }
      
      echo "</div></div>";
  }
  
  echo "</div></div></div>";
  $x++;
}

?>
        </div>
    </div>
    <div class="span9">
        
        
   
        
        