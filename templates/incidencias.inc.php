<!-- TODO: listado de incidencias con respuestas (sin paginar) -->
<!-- TODO: Saber rango de fechas -->

<ul class="nav nav-tabs" style="margin: 0 auto; width: 95%">
<?php
$idgrupoactivo="";
foreach ($cabeceras as $cabecera) {
    echo "<li";
    if ($cabecera->activa) {
        $idgrupoactivo=$cabecera->idgrupo;
        echo " class=\"active\"";
    }
    echo "><a href=\"?operacion=incidencias&idgrupo=".
        $cabecera->idgrupo."\">".$cabecera->grupo.
        " <span class=\"badge\">".$cabecera->incidenciasnuevas."</span></a></li>";
}
$idestado=$_REQUEST[idestado];
if (empty($idestado)){
    $idestado =1;
}
?>
</ul>
<div style="width: 95%; margin: 0 auto; padding: 1em;">
<ul class="nav nav-pills">
<!-- <li><a>Estado: </a></li> -->
<li<?php if ($idestado == 1) echo " class=\"active\""; ?>><a href="?operacion=incidencias&idgrupo=<?php echo $idgrupoactivo; ?>&idestado=1">Incidencias sen resolver</a></li>
<li<?php if ($idestado == 2) echo " class=\"active\""; ?>><a href="?operacion=incidencias&idgrupo=<?php echo $idgrupoactivo; ?>&idestado=2">Incidencias resoltas</a></li>
</ul>
</div>

<table class="table table-striped" style="margin: 0 auto; width: 95%;">
<thead>
<tr>
<th style="width: 15em;">Data</th>
<th style="width: 15em;">Nome</th>
<th style="width: 15em;">Ónde</th>
<th>Mensaxe</th>
<th style="width: 1em;">&nbsp;</th>
</tr>
</thead>

<?php
foreach($incidencias as $incidencia){
    echo "<tr>";
    echo "<td>".$incidencia->fechaCreacion;
    for ($i=0; $i < $incidencia->urgencia; $i++){
        echo " <span class=\"glyphicon glyphicon-alert\" style=\"color: red;\"></span>";
    }
    echo "</td>";
    
    echo "<td><a href=\"mailto:".$incidencia->email."\">".$incidencia->nombre."</a></td>";
    echo "<td>".$GLOBALS['localizaciones'][$incidencia->idlocalizacion]."</td>";
    echo "<td>".$incidencia->mensaje;
    //Comentarios (realmente están ordenados y se podría optimizar este bucle)
    //echo var_dump($comentarios);
    for($i=0; $i < count($GLOBALS['comentarios']); $i++){
        //echo "<pre>Comentario\n".var_dump($GLOBALS['comentarios'][$i]).".</pre>";
        $comentario=$GLOBALS['comentarios'][$i];
        if ($comentario[0]->idincidencia == $incidencia->idincidencia){
            for ($j =0; $j < count($comentario); $j++){
                //#FDF5E6
                echo "<div style=\"padding-top: 1em; margin-bottom: 2px; background-color: #FFFFF0; border: 1px #ccc solid; word-wrap: break-word; font-size: 90%;\"> ".$comentario[$j]->texto."<br/>";
                echo "Por: <span style=\"color: #000080\"><strong>".$comentario[$j]->usuario."</strong></span>, el: <span style=\"color: #2E8B57;\"><i>".$comentario[$j]->fechaHora."</i></span>. <span style=\"color: #A0522D\">Estado: ".$comentario[$j]->estado."</span>";
                echo "</div>";
            }
        }
    }
    echo "</td>";//Cierre de la columna mensaje

    //Enlace de gestión (estaría bien ponerlo "algo" mejor)
    echo "<td><a href=\"javascript:incidencia(".$incidencia->idincidencia.",'".$incidencia->nombre."','".$incidencia->email."'".",".$incidencia->idgrupo.");\" title=\"Editar/Xestionar\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td>";
    echo "</tr>";
    //TODO: Queda: Vínculo que permita añadir/reabrir incidencias al usuario, guardar IP y ordenador (local/publico)
    //TODO: Estadísticas
}

?>
</table>

<?php
require_once("templates/popupgestionincidencia.inc.php");
?>