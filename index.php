<?php

session_start();

require_once('includes/conectarbd.php');
require_once('includes/comun.lib.php');
ini_set("default_charset", "UTF-8");

$configuraciones=cargarConfiguraciones();
$localizaciones = cargarLocalizaciones();
$grupos = cargarGrupos();

//TODO: Cambiar clave del usuario
//TODO: Gestión de localizaciones
//TODO: Gestión de grupos
//TODO: Gestión de reserva de horarios de aulas (idea: no permitir reservar más de X días en el futuro)
//TODO: Gestión de préstamos de libros del departamento
//TODO: Gestión de aviso de guardias (o ticket a conserjería)
//TODO: Directorio web con formularios
//TODO: Aviso aula convivencia?
//TODO: Posibilidad de meter SMS aviso a padres y petición de informes a resto docentes
//TODO: Petición de tutorías
//TODO: Informes individualizados de alumnos

function comprobar_permiso($auxseccion) {
    global $configuraciones;
    $nombreConfiguracion="seccion_".$auxseccion."_login";
    switch($configuraciones[$nombreConfiguracion]) {
        case 'usuario':
            if (empty($_SESSION['usuario'])){
                header("Location: ?operacion=login");
                $_SESSION['SECCION']=$auxseccion;
                die();
            }
            break;
        case 'admin':
            if ($_SESSION['esadmin'] != "1"){
                header("Location: ?operacion=login");
                $_SESSION['SECCION']=$auxseccion;
                die();
            }
            break;
        default:
            $_SESSION['SECCION']='';
    }
}

//Recuperar ajustes de la operacion previa al login
$seccion = $_REQUEST['operacion'];
if ($seccion == "") {
    $seccion = $_SESSION['SECCION'];
}
global $BREADCRUM;
$BREADCRUM=strtoupper($seccion);

//Por seguridad
switch ($seccion) {
    case 'login':
        require('includes/login.php');
    break;

    case 'usuarios':
        comprobar_permiso("usuarios");
        require('includes/usuarios.php');
    break;
    
    case 'inventario':
        comprobar_permiso("inventario");
        require('includes/inventario.php');
    break;

    case 'localizaciones':
        comprobar_permiso("admin");
        require('includes/localizaciones.php');
    break;

    case 'incidencias':
        comprobar_permiso("incidencias");
        require('includes/incidencias.php');
    break;

    case 'webservice':
        // TODO: Cambiar clave. Mejorar esta parte
        $claveinventario = $configuraciones['claveinventario'];
        if ($claveinventario == "") {
            $claveinventario="setuppassword";
        }
        if ($_REQUEST['passwd'] != $claveinventario)
	       die("403 ERROR");
        require('includes/webservice.php');
    break;

    case 'logout':
        $BREADCRUM="";
        require('includes/logout.php');
    break;

    default:
        $BREADCRUM="CREARINCIDENCIA";
        comprobar_permiso("crearincidencia");
        require('includes/crearincidencia.php');
}

$mysqli->close();

?>
