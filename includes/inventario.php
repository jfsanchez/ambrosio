<?php

require_once("includes/ordenador.lib.php");

define("PLANTILLA", "inventario"); //define la plantilla a usar

global $ordenadores;

switch ($_POST['operacion2']){
    case 'buscarOrdenadores':
        buscarOrdenadorPorLocalizacion($_POST['lugar']);
        break;
        
    default:

}

function buscarOrdenadorPorLocalizacion($idlocalizacion) {
    global $ordenadores;
    $ordenadores= queryRoom($idlocalizacion);
}

// Cargar combo localizaciones


require("templates/generalweb.inc.php");


?>