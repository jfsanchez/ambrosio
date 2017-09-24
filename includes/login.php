<?php

define("PLANTILLA", "login"); //define la plantilla a usar

if ($_POST['operacion2'] == "1") {
    //comprobar usuario y clave
    //Si es correcto definir las variables SESSION
    $FRACASO=true;//Si el usuario o clave son incorrectos
    require_once("includes/login.lib.php");
    $usuario = login($_POST['usuario'], hash('sha256', $_POST['clave'].$GLOBALS['salt']));
    if ( ($usuario != null) && ($usuario->grupos != null) ){
        $FRACASO=false;
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['idusuario'] = $usuario->idusuario;
        $_SESSION['grupos'] = $usuario->grupos;
        $_SESSION['esadmin'] = $usuario->esadmin;
    }
}

if (empty($_SESSION['usuario'])) {
    //pinta la web de login
    require("templates/generalweb.inc.php");
} else {
    header("Location: ?operacion=incidencias");
    die();
}

?>