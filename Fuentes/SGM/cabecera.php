<?php
@session_start();
require_once("config/parametros.php");
// Para no permitir ingresar si no se ha iniciado sesión
if(isset($_SESSION['usuario']) == FALSE)
{
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>   
<html lang="en">   
<head>   
<meta charset="utf-8">   
<title><?php echo $V_TITULO; ?></title>     
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">  
<!-- Responsive -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.js"></script>
<script type="text/javascript" src="js/jquery.redirect.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- DataTable plugin -->
<script type="text/javascript" src="js/DT/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">
    @import "css/DT/demo_page.css";
    @import "css/DT/demo_table.css";
    @import "css/DT/demo_table_jui.css";
    @import "css/DT/jquery.dataTables_themeroller.css";
    
</style>
<!-- Select -->
<link href="css/bootstrap-select.css" rel="stylesheet" />
<script src="js/bootstrap-select.js" type="text/javascript"></script>
<!-- DatePicker -->
<link href="css/datepicker.css" rel="stylesheet" />
<script src="js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="js/bootstrap-datepicker.es.js" type="text/javascript"></script>
<!-- Dialogos -->
<script src="js/bootbox.min.js" type="text/javascript"></script>
<!-- Rut -->
<script src="js/jquery.Rut.js" type="text/javascript"></script>

<script type="text/javascript">

	var flag = true;
	
	function OcultaFiltros()
	{
		if(flag == true)
		{
			$("#txtbtnFiltros").html("Búsqueda Básica");
			$("#btnFiltros").removeClass( "icon-chevron-down" ).addClass( "icon-chevron-up" );
			$(".filtroAvanzado").show();
			flag = false;
		}	
		else
		{
			$("#txtbtnFiltros").html("Búsqueda Avanzada");
			$("#btnFiltros").removeClass( "icon-chevron-up" ).addClass( "icon-chevron-down" );
			$(".filtroAvanzado").hide();
			flag = true;
		}
	}
	
	function validaFormatoPass(pass) {
		if (!/^[a-zA-Z0-9\.]{4,20}$/.test(pass)) {
			return false;
		}
		return true;
	}
	
	function ValidaCorreo(texto){
		
		if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(texto)) {
			return false;
		}
		return true;
	}
	
	function ValidaNumerico(texto){
		
		if (!/^[0-9]{1,10}$/.test(texto)) {
			return false;
		}
		return true;
	}
	
	function ValidaTexto(texto,longitud){
		
		var re = RegExp("^[a-zA-ZáéíóúÁÉÍÓÚñ0-9\s\'\-\.\#\_/ ]{1,"+longitud+"}$");
		if (!re.test(texto.trim())) {
			return false;
		}
		return true;
	}
	
	function ValidaRut(texto){
		
		if (!/^[0-9]{1,8}-[0-9kK]{1}$/.test(texto)) {
			return false;
		}
		return true;
	}
	
	function ValidaAlfaNumerico(texto, longitud){
		
		var re = RegExp("^[a-zA-Z0-9]{1,"+longitud+"}$");
		if (!re.test(texto.trim())) {
			return false;
		}
		return true;
	}
	
    function ValidaFecha(texto){
        
        if (!/^\d{2}[\-]\d{2}[\-]\d{4}$/.test(texto)) {
            return false;
        }
        return true;
    }
    
    function ValidaFechaDiff(fechaInicio, fechaFin){
        
        var x = fechaInicio.split("-");
        fechaInicio = x[1] + "/" + x[0] + "/" + x[2];
        var d1 = new Date(fechaInicio);
        x = fechaFin.split("-");
        fechaFin = x[1] + "/" + x[0] + "/" + x[2];
        var d2 = new Date(fechaFin);
        var datediff = d2.getTime() - d1.getTime();
        var dias = (datediff / (24*60*60*1000));
        
        if(dias > 0){
            return true;
        }
        else{
            return false;
        }
    }

	function MostrarAdvertencia(mensaje, array) {
		MostrarMensaje(mensaje, array, "");
	}

	function MostrarExito(mensaje, array) {
		MostrarMensaje(mensaje, array, "alert-success");
	}

	function MostrarError(mensaje, array) {
		MostrarMensaje(mensaje, array, "alert-error");
	}

	function MostrarMensaje(mensaje, array, tipo) {
		var msj = "<div class='alert " + tipo + "'><button type='button' class='close' data-dismiss='alert'>&times;</button>";
		msj = msj + "<strong>" + mensaje + "</strong>";

		if (array != null) {
			array.forEach(function(entry) {
				msj = msj + "<p>" + entry + "</p>";
			});
		}

		$('#divErrores').html(msj);
	}
	
	$(function() {
		$(".filtroAvanzado").hide();
		
		$('#divLoading').hide();
		
		$("body").on({
		    ajaxStart: function() { 
		        $('#divLoading').show();
		    },
		    ajaxStop: function() { 
		        $('#divLoading').hide();
		    }    
	  	});
	  	
	  	$('.selectpicker').selectpicker({

        });
        
        $('.txtFecha').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            language: "es",
            autoclose: true
        });
	  	
	});

    function CerrarSesion(){
        Ir("IniSes/logout.php");
    }
    
    function Ir(ruta){
        window.location.href = ruta;
    }
    
    function MisDatos(){
        Ir("misdatos.php");
    }
    
    function Main(){
        Ir("main.php");
    }
    
    // Para recargar la tabla
	$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
	{
	    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
	        oSettings.sAjaxSource = sNewSource;
	    }
	 
	    if ( oSettings.oFeatures.bServerSide ) {
	        this.fnDraw();
	        return;
	    }
	 
	    this.oApi._fnProcessingDisplay( oSettings, true );
	    var that = this;
	    var iStart = oSettings._iDisplayStart;
	    var aData = [];
	  
	    this.oApi._fnServerParams( oSettings, aData );
	      
	    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
	        that.oApi._fnClearTable( oSettings );
	          
	        var aData =  (oSettings.sAjaxDataProp !== "") ?
	            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
	          
	        for ( var i=0 ; i<aData.length ; i++ )
	        {
	            that.oApi._fnAddData( oSettings, aData[i] );
	        }
	          
	        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
	          
	        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
	        {
	            oSettings._iDisplayStart = iStart;
	            that.fnDraw( false );
	        }
	        else
	        {
	            that.fnDraw();
	        }
	          
	        that.oApi._fnProcessingDisplay( oSettings, false );
	          
	        if ( typeof fnCallback == 'function' && fnCallback != null )
	        {
	            fnCallback( oSettings );
	        }
	    }, oSettings );
	};
	
	// Para el estilo de la tabla de detalle
	(function ($) {
        $.fn.styleTable = function (options) {
            var defaults = {
                css: 'styleTable'
            };
            options = $.extend(defaults, options);

            return this.each(function () {

                input = $(this);
                input.addClass(options.css);

                input.find("tr").live('mouseover mouseout', function (event) {
                    if (event.type == 'mouseover') {
                        $(this).children("td").addClass("ui-state-hover");
                    } else {
                        $(this).children("td").removeClass("ui-state-hover");
                    }
                });

                input.find("th").addClass("ui-state-default");
                input.find("td").addClass("ui-widget-content");

                input.find("tr").each(function () {
                    $(this).children("td:not(:first)").addClass("first");
                    $(this).children("th:not(:first)").addClass("first");
                });
            });
        };
    })(jQuery);
</script>

<style type="text/css">
@import "css/dataTables.bootstrap.css";
</style>
<style type="text/css">

#divLoading{
  position: fixed;
  _position: absolute;
  z-index: 99;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  opacity:0.6;
  background-color:#ffffff;
  _height: expression(document.body.offsetHeight + "px");
}

.bubblingG {
    text-align: center;
    width:150px;
    height:94px;
}

.bubblingG span {
    display: inline-block;
    vertical-align: middle;
    width: 19px;
    height: 19px;
    margin: 47px auto;
    background: #1E93C9;
    -moz-border-radius: 94px;
    -moz-animation: bubblingG 1.3s infinite alternate;
    -webkit-border-radius: 94px;
    -webkit-animation: bubblingG 1.3s infinite alternate;
    -ms-border-radius: 94px;
    -ms-animation: bubblingG 1.3s infinite alternate;
    -o-border-radius: 94px;
    -o-animation: bubblingG 1.3s infinite alternate;
    border-radius: 94px;
    animation: bubblingG 1.3s infinite alternate;
}

#bubblingG_1 {
    -moz-animation-delay: 0s;
    -webkit-animation-delay: 0s;
    -ms-animation-delay: 0s;
    -o-animation-delay: 0s;
    animation-delay: 0s;
}

#bubblingG_2 {
    -moz-animation-delay: 0.39s;
    -webkit-animation-delay: 0.39s;
    -ms-animation-delay: 0.39s;
    -o-animation-delay: 0.39s;
    animation-delay: 0.39s;
}

#bubblingG_3 {
    -moz-animation-delay: 0.78s;
    -webkit-animation-delay: 0.78s;
    -ms-animation-delay: 0.78s;
    -o-animation-delay: 0.78s;
    animation-delay: 0.78s;
}

@-moz-keyframes bubblingG {
    0% {
    width: 19px;
    height: 19px;
    background-color:#1E93C9;
    -moz-transform: translateY(0);
    }
    100% {
    width: 45px;
    height: 45px;
    background-color:#FFFFFF;
    -moz-transform: translateY(-39px);
    }
}

@-webkit-keyframes bubblingG {
    0% {
    width: 19px;
    height: 19px;
    background-color:#1E93C9;
    -webkit-transform: translateY(0);
    }
    100% {
    width: 45px;
    height: 45px;
    background-color:#FFFFFF;
    -webkit-transform: translateY(-39px);
    }
}

@-ms-keyframes bubblingG {
    0% {
    width: 19px;
    height: 19px;
    background-color:#1E93C9;
    -ms-transform: translateY(0);
    }
    100% {
    width: 45px;
    height: 45px;
    background-color:#FFFFFF;
    -ms-transform: translateY(-39px);
    }
}

@-o-keyframes bubblingG {
    0% {
    width: 19px;
    height: 19px;
    background-color:#1E93C9;
    -o-transform: translateY(0);
    }
    100% {
    width: 45px;
    height: 45px;
    background-color:#FFFFFF;
    -o-transform: translateY(-39px);
    }
}

@keyframes bubblingG {
    0% {
    width: 19px;
    height: 19px;
    background-color:#1E93C9;
    transform: translateY(0);
    }
    100% {
    width: 45px;
    height: 45px;
    background-color:#FFFFFF;
    transform: translateY(-39px);
    }
}

</style>
</head>  
<body>
    
<div id="divLoading">
    <center>
    <div class="bubblingG" style="top: 30%;position: absolute;left: 50%;" >
        <span id="bubblingG_1"></span>
        <span id="bubblingG_2"></span>
        <span id="bubblingG_3"></span>
    </div>
    </center>
</div>
    
<form id="FormPrincipal">

<div class="navbar navbar-default" >
  <div class="navbar-inner btn-primary">
    <a class="brand" href="#"><?php echo $V_TITULO; ?></a>
    <ul class="nav" style="float: right">
      <li class="active"><a href="javascript:Main();"><i class="icon-user"></i><?php echo " Bienvenido ". $_SESSION['usuario'] ?></a></li>
      <li><a href="javascript:MisDatos();"><i class="icon-home"></i> Mis Datos</a></li>
      <li><a href="javascript:CerrarSesion();"><i class="icon-off"></i> Cerrar Sesión</a></li>
    </ul>
  </div>
</div>


