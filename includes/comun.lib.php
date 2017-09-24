<?php

function cargarConfiguraciones() {
    $auxconfiguracion = $GLOBALS['mysqli']->query("SELECT variable, valor FROM configuracion");//mysqli_fetch_array(, MYSQLI_BOTH)
    while ($aux = $auxconfiguracion->fetch_assoc()) {
        $configuracion[$aux['variable']]= $aux['valor'];
    }
    $auxconfiguracion->close();
    return $configuracion;
}

function cargarLocalizaciones() {
    $auxlocalizaciones = $GLOBALS['mysqli']->query("SELECT idlocalizacion, nombreaula FROM localizaciones");
    while ($aux = $auxlocalizaciones->fetch_assoc()) {
        $localizaciones[$aux['idlocalizacion']]= $aux['nombreaula'];
    }
    $auxlocalizaciones->close();
    return $localizaciones;
}

function cargarGrupos(){
    $auxgrupos = $GLOBALS['mysqli']->query("SELECT idgrupo, nombre FROM grupo");
    while ($aux = $auxgrupos->fetch_assoc()) {
        $grupos[$aux['idgrupo']]= $aux['nombre'];
    }
    $auxgrupos->close();
    return $grupos;
}

function tratarDato($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
