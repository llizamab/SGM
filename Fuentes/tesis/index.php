<!DOCTYPE html>   
<html lang="en">   
<head>   
<meta charset="utf-8">   
<title>Example of stacked navigation with nav list with icons</title>   
<meta name="description" content="Example of stacked navigation with nav list icons. Nav list consits of several icons like for book, pencil etc.">  
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">  
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
  $(function() {
      
      $("#btnProyecto").click(function(){
          alert("hola");
      })
      
  });

</script>
</head>  
<body>  
    
<div class="navbar navbar-inverse" >
  <div class="navbar-inner">
    <a class="brand" href="#">Title</a>
    <ul class="nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Link</a></li>
      <li><a href="#">Link</a></li>
    </ul>
  </div>
</div>


<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
         <div class="bs-example">
            <div id="myAccordion" class="accordion">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a href="#collapseOne" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">1. What is HTML?</a>
                    </div>
                    <div class="accordion-body collapse" id="collapseOne">
                        <div class="accordion-inner">
                            <p>Primer ejemplo <a href="http://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
                        </div>
                    </div>
                </div>    
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a href="#collapseTwo" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">2. What is Twitter Bootstrap?</a>
                    </div>
                    <div class="accordion-body collapse in" id="collapseTwo">
                        <div class="accordion-inner">
                            <p>segundo ejemplo <a href="http://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn more.</a></p>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a href="#collapseThree" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">3. What is CSS?</a>
                    </div>
                    <div class="accordion-body collapse" id="collapseThree">
                        <div class="accordion-inner">
                            <p> 3r ejemplo <a href="http://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a href="#collapseFour" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">Titulo</a>
                    </div>
                    <div class="accordion-body collapse" id="collapseFour">
                        <div class="accordion-inner">
                            <input type="button" value="Proyectos" id="btnProyecto" class="btn-danger"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span9">
      
      <!-- Contenido -->
      <div></div>
      <div></div>
        
    </div>
</div>

  
</body>  
</html> 
