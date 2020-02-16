<?php
define(PLANTILLA, "incidencias");

require_once("includes/incidencias.lib.php");

class CabeceraIncidencia{
    public $idgrupo;
    public $grupo;
    public $incidenciasnuevas;
    public $activa;
}

//TODO: Refactorizar con switch por operacion y default
if ($_REQUEST['operacion2']=="cambiar"){
    //Comprobar que el usuario tenga permiso al grupo ($_SESSION['grupos']
    $auxincidencia=buscarIncidenciaId($_REQUEST['idincidencia']);
    if (empty($auxincidencia)){die("ERROR");}
    $tieneacceso=false;
    //no uso in_array a propósito ¡ojo!
    for($i=0; $i < count($_SESSION['grupos']); $i++){
        if ($_SESSION['grupos'][$i] == $auxincidencia->idgrupo){
            $tieneacceso=true;
        }
    }
    if (!$tieneacceso) {
        die("ERROR: Esa incidencia pertenece actualmente a un grupo para el que no tiene acceso");
    }
    cambiarEstado($_POST['idincidencia'], $_POST['idestado'], $_POST['idgrupo']);
    insertarComentario($_POST['idincidencia'], $_SESSION['idusuario'], $_POST['texto'], $_POST['idestado'], $_POST['mandaremail']);
    
    die("+200 OK");
}

$cabecera_activa = $_REQUEST['idgrupo'];
if (empty($cabecera_activa)) {
    $cabecera_activa=$_SESSION['grupos'][0];
}

$acceso=false;
foreach ($_SESSION['grupos'] as $auxgrupo){
    $auxcabecera = new CabeceraIncidencia();
    $auxcabecera->idgrupo=$auxgrupo;
    if ($auxgrupo == $cabecera_activa){
        $acceso=true;
    }
    $auxcabecera->grupo=$GLOBALS['grupos'][$auxgrupo];
    //Cargar de una sola consulta todos los contadores
    $estadisticas=contarNuevasIncidencias(1);//1= estado nuevo
    $auxcabecera->incidenciasnuevas=$estadisticas[$auxgrupo];
    $auxcabecera->activa=false;
    if ($cabecera_activa == $auxgrupo) {
        $auxcabecera->activa=true;
    }
    $cabeceras[]=$auxcabecera;
}

$idestado=$_REQUEST['idestado'];
if (empty($idestado)){
    $idestado=1;
}

if ($acceso == true) {
    //Cargar las incidencias de la cabecera activa
    $incidencias=buscarIncidencias($cabecera_activa, $idestado);
    //Cargar los comentarios de las incidencias
    foreach ($incidencias as $incidencia){
        $comentarios[]=buscarComentarios($incidencia->idincidencia);
    }
}

require("templates/generalweb.inc.php");

?>