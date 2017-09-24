<div style="margin: 0 auto; width: 80%;">

<h4 style="padding: 0,3em;">Lista de usuarios</h4>

<div class="alert alert-info">
<p>* <strong>Nota 1:</strong> Un usuario sen ningún grupo <strong>NON</strong> pode iniciar sesión (está desactivado)</p>
<p>* <strong>Nota 2:</strong> Para ver reflectidos os cambios, o usuario debe pechar e abrir sesión de novo</p>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Usuario</th>
      <th>Clave</th>
      <th>Grupos</th>
      <th>Operacións</th>
    </tr>
</thead>

<?php
$i=0;
foreach($usuarios as $usuario){
    echo "<tr><form action=\"index.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"operacion\" value=\"usuarios\"/>";
    echo "<input type=\"hidden\" name=\"operacion2\" value=\"editar\"/>";
    echo "<input type=\"hidden\" name=\"idusuario\" value=\"".$usuario->idusuario."\"/>";
    
    echo "<td>".$usuario->usuario."</td>";
    echo "<td><input type=\"text\" name=\"clave\" placeholder=\"Contrasinal novo\"></td>";
    echo "<td>";

    $i++;
    foreach($grupos as $clave => $valor){
        echo "<input type=\"checkbox\" id=\"".$i."c-".$clave."\" class=\"form-check-input\" name=\"".$clave."\" ";
        if (!empty($usuario->grupos)) {
            for($j=0; $j < count($usuario->grupos); $j++){
                if ($usuario->grupos[$j] == $clave){
                    echo "checked=\"checked\"";
                    break;
                }
            }
            
        }
        echo "/> <label style=\"padding-left: 0,5em; padding-right: 3em;\" class=\"form-check-label\" for=\"".$i."c-".$clave."\">$valor</label>";
    }

    echo "<input type=\"checkbox\" id=\"admin-".$usuario->idusuario."\" class=\"form-check-input\" name=\"esadmin\" ";
    if ($usuario->esadmin =="1"){
        echo "checked=\"checked\"";
    }
    echo "/> <label style=\"padding-left: 0,5em; padding-right: 3em;\" class=\"form-check-label\" for=\"admin-".$usuario->idusuario."\">Administrador</label>";
    echo "</td>";
    echo "<td><input type=\"submit\" value=\"Cambiar\" class=\"btn btn-default\"></td>";
    echo "</form></tr>";

}
?>

</table>


<h4 style="padding: 0,3em;">Creación de usuarios</h4>
<form action="index.php" method="post" class="form-inline">
  <label for="usuario">Usuario:</label>
  <input type="text" name="usuario" id="usuario" class="form-control" required autofocus/>
  
  <label for="clave">Contrasinal:</label>
  <input type="text" name="clave" id="clave" class="form-control" required/>
  
  <input type="checkbox" name="esadmin" id="esadmin" class="form-check-input"/>
  <label for="esadmin">¿É administrador?</label>
  
  <input type="hidden" name="operacion" value="usuarios"/>
  <input type="hidden" name="operacion2" value="crear"/>
  

<!--   <div class="form-group row"> -->
  <div class="form-check form-check-inline">
    <?php
        foreach($grupos as $clave => $valor){
            echo "<input type=\"checkbox\" id=\"nc-".$clave."\" class=\"form-check-input\" name=\"".$clave."\"/> <label style=\"padding-left: 0,5em; padding-right: 3em;\" class=\"form-check-label\" for=\"nc-".$clave."\">$valor</label>";
        }
    ?>
  </div>
  <input type="submit" value="Crear usuario" class="btn btn-default btn-group-lg"/>

</form>

</div>
