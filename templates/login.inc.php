<?php
if ($FRACASO) {
?>
<div class="alert alert-danger" style="margin: 0 auto; width: 80%;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>ERRO:</strong> Usuario ou contrasinal incorrectos
</div>
<div style="clear: both;"><p>&nbsp;</p></div>
<?php 
}
?>
<div class="col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-5">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<input type="hidden" name="operacion" value="login"/>
<input type="hidden" name="operacion2" value="1"/>

  <label for="usuario">Usuario:</label>
  <input class="form-control" type="text" value="<?php echo $aux_usuario; ?>" 
  		name="usuario" id="usuario" placeholder="Nome de usuario" required autofocus/>

    <label for="clave">Contrasinal:</label>
    <input class="form-control" type="password" value="" name="clave" id="clave" required/>

    <input type="submit" class="btn btn-default btn-group-lg" value="Acceder" id="enviar" style="margin-top: 1em;"/>

</form>
</div>