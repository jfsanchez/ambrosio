<form action="index.php" method="post">

<input type="hidden" name="operacion" value="inventario"/>
<input type="hidden" name="operacion2" value="buscarOrdenadores"/>


<div class="container">

<h2>Inventario de equipos</h2>
  <label for="lugar">Seleccione localización para ver o inventario de equipos:</label>
  <select class="form-control" id="lugar" name="lugar" required='required'>
<?php
    foreach($localizaciones as $clave => $valor){
        if ( ($clave == $_POST['lugar']) || ($clave==$idlocalizacion) ) {
            echo "<option value=\"".$clave."\" selected=\"selected\">".$valor."</option>";
        } else {
            echo "<option value=\"".$clave."\">".$valor."</option>";
        }
    }
?>
  </select>
  <br/>
  <input type="submit" class="btn btn-primary btn-lg btn-block" value="Consultar"/>
 </form>
 
<table class="table table-striped" style="margin: 0 auto; width: 95%;">
<thead>
<tr>
	<th >MAC</th>
	<th >Etiqueta</th>
	<th >Boca</th>
	<th >Fil</th>
	<th >Col</th>
	<th style="width: 15em;">Procesador</th>
	<th >RAM</th>
	<th >SSD</th>
	<th >HDD</th>
	<th >Fuente Alimentación</th>
	<th >Fecha Montaje</th>
	<th >Fecha Instalación</th>
</tr>
</thead>
<tbody>

<?php

global $ordenadores;

foreach($ordenadores as $ordenador){
    echo "<tr>";
    echo "<td>".$ordenador->getMac()."</td>";
    echo "<td>".$ordenador->getEtiqueta()."</td>";
    echo "<td>".$ordenador->getBoca()."</td>";
    echo "<td>".$ordenador->getFila()."</td>";
    echo "<td>".$ordenador->getColumna()."</td>";
    echo "<td>".$ordenador->getCpu()."</td>";
    echo "<td>".$ordenador->getRam()."</td>";
    echo "<td>".$ordenador->getSsd()."</td>";
    echo "<td>".$ordenador->getHdd()."</td>";
    echo "<td>".$ordenador->getFuentealimentacion()."</td>";
    echo "<td>".$ordenador->getFechaMontaje()."</td>";
    echo "<td>".$ordenador->getFechaInstalacion()."</td>";
    echo "</tr>";
}
?>
</tbody>
</table>

 </div>