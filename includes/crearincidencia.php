<?php
    require_once("includes/incidencias.lib.php");
    require_once("includes/notificaciones.lib.php");
    require_once("includes/ordenador.lib.php");

    define("PLANTILLA", "crearincidencia"); //define la plantilla a usar
    
    $idlocalizacion=0;
    if ($_GET['mac'] != "") {
        $computer=queryComputer($_GET['mac']);
        $idlocalizacion=$computer->getIdLocalizacion();
    }
    
    $error=false;

    //TODO: Meter sistema antispam que tengo para blog basado en javascript
    
    //Si nos han enviado el formulario
    if ($_POST['operacion2'] == "1") {
        
        $nombre = tratarDato($_POST['nombre']);
        if (empty($nombre)){
            $ERROR['nombre']=true;
        }
        
        $email = tratarDato($_POST['email']);
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $ERROR['email']=true;
        }
        
        $urgencia = tratarDato($_POST['urgencia']);
        if ( ($urgencia != "0") && ($urgencia != "1") ){
            $ERROR['urgencia']=true;
        }
        
        $lugar = tratarDato($_POST['lugar']);
        if (empty($lugar) || empty($localizaciones[$lugar])){
            $ERROR['lugar']=true;
        }
        
        $grupo = tratarDato($_POST['grupo']);
        if (empty($grupo)|| empty($grupos[$grupo])){
            $ERROR['grupo']=true;
        }
        
        $textoincidencia = tratarDato($_POST['textoincidencia']);
        if (empty($textoincidencia)){
            $ERROR['textoincidencia']=true;
        }
        
        $procesar=true;
        if (! empty($ERROR)) {
            foreach ($ERROR as $campo => $fallo) {
                if ($fallo) {
                    $procesar = false;
                    $FRACASO = true;
                }
            }
        }
        
        //Crear incidencia y notificarla
        if ($procesar) {
            $incidencia = new Incidencia();
            $incidencia->email=$email;
            //$incidencia->fechaCreacion=date_timestamp_get();
            //$incidencia->fechaResolucion=null;
            $incidencia->idestado=1;
            $incidencia->idgrupo=$grupo;
            $incidencia->idincidencia=null;
            $incidencia->idlocalizacion=$lugar;
            $incidencia->mensaje=$textoincidencia;
            $incidencia->nombre=$nombre;
            $incidencia->urgencia=$urgencia;
            $incidencia->tokenweb= substr(str_shuffle(str_repeat(
                "0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $incidencia = crearIncidencia($incidencia);
            if ($incidencia == null){
                $FRACASO=true;
            }else{
                //Notificar al usuario y al departamento encargado
                //notificarIncidencia($incidencia, true, true); // TODO: Queda la notificacion
                $EXITO=true;
            }
        }
        
    }
    
    //pinta la web
    require("templates/generalweb.inc.php");
?>
