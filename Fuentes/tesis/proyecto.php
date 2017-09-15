<?php

include("cabecera.php");

include("menu.php")

?>

<!--  -->
<div class="row">
    <div class="span6">
        <fieldset>
        <legend>Filtros de Búsqueda</legend>
            <label>Código Proyecto</label>
            <input type="text" placeholder="Smith" class="input-xlarge">
            <label>Nombre Proyecto</label>
            <input type="text" placeholder="K" class="input-xlarge">
            <label>First Name</label>
            <input type="text" placeholder="John" class="input-xlarge">
        </fieldset>
    </div>
    <div class="span6">
        <fieldset>
        <legend> &nbsp;</legend>
        <label>Cliente</label>
        <select name="Gender" id="DropdownGender" class="input-xlarge">
            <option value="">Male</option>
            <option value="">Female</option>
        </select>
        <label>Cliente</label>
        <select name="Gender" id="DropdownGender" class="input-xlarge">
            <option value="">Male</option>
            <option value="">Female</option>
        </select>
        </fieldset>
    </div>
</div>
<div>&nbsp;</div>
<div class="row">
    <div class="container theme-showcase">
        <p>
            <button type="button" class="btn btn-lg btn-primary">Default</button>
            <button type="button" class="btn btn-lg btn-primary">Primary</button>
            <button type="button" class="btn btn-lg btn-primary">Success</button>
            <button type="button" class="btn btn-lg btn-primary">Info</button>
            <button type="button" class="btn btn-lg btn-primary">Warning</button>
            <button type="button" class="btn btn-lg btn-primary">Danger</button>
            <button type="button" class="btn btn-lg btn-primary">Link</button>
        </p>
    </div>
</div>
<div>&nbsp;</div>
<div class="row">
    <div class="span12">
        <table class="table table-striped table-bordered    ">
        <thead>
          <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cliente</th>
            <th>..</th>
            <th>Ver</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img src="images/Estrella-amarrilla.PNG" /></td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Mark</td>
            <td>Otto</td>
                  
          </tr>
          <tr>
            <td><img src="images/Estrella-blanca.PNG" /></td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>Mark</td>
            <td>Otto</td>
          </tr>
          <tr>
            <td>3</td>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
            <td>Mark</td>
            <td>Otto</td>
            
          </tr>
        </tbody>
      </table>
    </div>
</div>



<?php

include("footer.php");

?>

