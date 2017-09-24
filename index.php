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

global $BREADCRUM;

switch ($_REQUEST['operacion']) {

    case 'login':
    $BREADCRUM="LOGIN";
    require('includes/login.php');
    break;

    case 'usuarios':
    if ($_SESSION['esadmin'] != "1"){
        die("Acceso denegado");//mejorar
    }
    $BREADCRUM="USUARIOS";
    require('includes/usuarios.php');
    break;

    case 'localizaciones':
    require('includes/localizaciones.php');
    break;

    case 'incidencias':
    if (empty($_SESSION['usuario'])){
        die("Acceso denegado");//mejorar
    }
    $BREADCRUM="INCIDENCIAS";
    require('includes/incidencias.php');
    break;
    
    case 'logout':
    require('includes/logout.php');
    break;

    default:
    $BREADCRUM="CREARINCIDENCIA";
    require('includes/crearincidencia.php');
}

$mysqli->close();

?>


