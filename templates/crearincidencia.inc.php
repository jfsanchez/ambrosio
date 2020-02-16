<?php 

if ($EXITO) {
?>
<div class="alert alert-success" style="margin: 0 auto; width: 80%;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Enviada:</strong> A súa incidencia foi enviada correctamente. Enviouse confirmación ao seu correo.
</div>
<div style="clear: both;"><p>&nbsp;</p></div>
<?php
return;
}
if ($FRACASO) {
?>
<div class="alert alert-danger" style="margin: 0 auto; width: 80%;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>ERRO:</strong> Non se puido enviar a incidencia. Por favor, corrixa os campos en vermello.
</div>
<div style="clear: both;"><p>&nbsp;</p></div>
<?php 
}

?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="width: 80%; margin: 0 auto;">
<input type="hidden" name="operacion" value="crearincidencia"/>
<input type="hidden" name="operacion2" value="1"/>

<div class="form-group row">
 <div class="col-xs-4<?php if ($ERROR['nombre']) echo $ERROR_INPUT_CLASSNAME;?>">
  <label for="nombre">Eu son:</label>
  <input class="form-control" type="text" value="<?php if (empty($_POST['operacion2']) && !empty($_SESSION['usuario'])) echo $_SESSION['usuario']; else echo $_POST['nombre']; ?>" name="nombre" id="nombre" placeholder="Nome e apelidos" required autofocus<?php if ($_SESSION['usuario'] != "") { echo " readonly"; } ?> />
 </div>

 <div class="col-xs-4<?php if ($ERROR['email']) echo $ERROR_INPUT_CLASSNAME;?>">
  <label for="email">O meu email é:</label>
  <input class="form-control" type="text" value="<?php if (empty($_POST['operacion2']) && !empty($_SESSION['usuario'])) echo $_SESSION['usuario']."@localhost"; else echo $_POST['email']; ?>" name="email" id="email" placeholder="email@email.email" required/>
 </div>

 <div class="col-xs-2<?php if ($ERROR['urgencia']) echo $ERROR_INPUT_CLASSNAME;?>">
  <label for="urgencia">¿É urxente?</label>
  <select class="form-control" name="urgencia" id="urgencia" required='required'>
  	<option value="0"<?php if ($_POST['urgencia']=="0") echo " selected=\"selected\""; ?>>NON</option>
  	<option value="1"<?php if ($_POST['urgencia']=="1") echo " selected=\"selected\""; ?>>SI</option>
  </select>
 </div>
</div>

<div class="form-group row">
 <div class="col-xs-6<?php if ($ERROR['lugar']) echo $ERROR_INPUT_CLASSNAME;?>">
  <label for="lugar">¿Onde ocorre?</label>
  <select class="form-control" name="lugar" id="lugar" required='required'>
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
 </div>
 <div class="col-xs-4<?php if ($ERROR['grupo']) echo $ERROR_INPUT_CLASSNAME;?>">
  <label for="grupo">¿Qué tipo de problema é?</label>
  <select class="form-control" name="grupo" id="grupo" required='required'>
  <?php
    foreach($grupos as $clave => $valor){
        if ($clave == $_POST['grupo']){
            echo "<option value=\"".$clave."\" selected=\"selected\">".$valor."</option>";
        } else {
            echo "<option value=\"".$clave."\">".$valor."</option>";
        }
    }
  ?>
  </select>
 </div>
</div>

<div class="form-group row">
 <div class="col-xs-10<?php if ($ERROR['textoincidencia']) echo $ERROR_INPUT_CLASSNAME;?>">
   <label for="textoincidencia">¿Cal é o problema?</label>
   <textarea maxlength="5000" id="textoincidencia" rows="5" class="form-control input-lg" name="textoincidencia" placeholder="Por favor, describe o problema de forma clara e concisa" required>
<?php
   if (!empty($auxmac))
       echo "MAC do equipo (deixe esto): ".htmlentities(substr($auxmac,0,17));
   else
       echo $_POST['textoincidencia'];
   ?></textarea>
 </div>
</div>

<div class="form-group row col-xs-10">
<input type="submit" class="btn btn-default btn-group-lg" value="Enviar" id="enviar"/>
</div>

</form>
<div style="clear: both;"></div>
