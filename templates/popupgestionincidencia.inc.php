
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#comentarioModal">Open Modal</button> -->

<form id="formulariocomentario">
<div id="comentarioModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

<div class="modal-body">
<textarea class="form-control input-lg" id="comentario" name="comentario" cols="80" rows="8" maxlength="5000" placeholder="Introduza o comentario. Se marca o check, enviarase a resposta ao usuario %nombre% por email a %email%"></textarea>

<div class="form-group row"  style="width:99%; margin: 0 auto;">
<!--   <div class="col-xs-4"> -->
    <input type="checkbox" id="mandaremail" name="mandaremail" /> <label for="mandaremail"> Mandar esta resposta por email ao usuario</label>
  </div>
<!--   <div class="col-xs-5"> -->
<div class="form-group row" style="width:99%; margin: 0 auto;">
    <label for="grupo">Reasignar a outro grupo encargado: </label>
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
<!-- </div> -->
<div class="modal-footer">
  <button type="button" class="btn btn-danger" onclick="javascript:borrarDatos();">Cancelar</button>
  <button type="button" class="btn btn-info" id="botonguardar" onclick="javascript:procesarIncidencia(1);">Gardar</button>
  <button type="button" class="btn btn-success" onclick="javascript:procesarIncidencia(2);" id="botonsolucionar">Gardar e solucionar</button>
</div>
</div>

</div>
</div>
</div>

</form>

<script>
var idincidencia;
var autor;
var email;
var idgrupo;

function incidencia(auxidincidencia, auxautor, auxemail, auxidgrupo){
	//Cambiar valores de variables para enviar formulario
	idincidencia=auxidincidencia;
	autor=auxautor;
	email=auxemail;
	idgrupo=auxidgrupo;
	$("#comentarioModal").modal("show");
	$("#grupo").val(idgrupo);
}

function borrarDatos(){
	idincidencia="";
	autor="";
	email="";
	$("#mandaremail").prop('checked', false);
	$("#comentario").val('');
	$("#grupo").val(1);
	$("#comentarioModal").modal("hide");
}

function procesarIncidencia(nuevoEstado){
	
	//alert('Estoy en ello, el estado nuevo sera: ' + nuevoEstado + " " + $("#comentario").val() + " " + email);

	var datosFormulario={'operacion':'incidencias',
			'operacion2': 'cambiar',
			'idincidencia': idincidencia,
			'mandaremail':  $("#mandaremail").val(),
			'idgrupo': $("#grupo").val(),
			'texto': $("#comentario").val(),
			'idestado': nuevoEstado};
	
	var jqxhr = $.post( "index.php", datosFormulario, function(data) {
		  //rueda de carga (si se quiere)

		})
		  .done(function() {
			//Borrar campos
			borrarDatos();
			location.reload(); //recargar la página
		  })
		  .fail(function(data) {
		    alert( "Erro descoñecido: Por favor, volva a intentalo. Se o erro persiste, contacte cos responsables" + data.statusText);
		  })
		  .always(function() {
		    
		  });

}

</script>