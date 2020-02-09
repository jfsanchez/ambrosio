<?php

require_once("includes/ordenador.lib.php");

    switch ($_REQUEST['op2']) {
        case 's':
            //Por probar funcionamiento
            $computer = new Computer;
            $computer->setIdLocalizacion($_REQUEST['idlocalizacion']);
            $computer->setEtiqueta($_REQUEST['etiqueta']);
            $computer->setMac($_REQUEST['mac']);
            $computer->setIp($_REQUEST['ip']);
            $computer->setDns($_REQUEST['dns']);
            $computer->setBoca($_REQUEST['boca']);
            $computer->setRam($_REQUEST['ram']);
            $computer->setSsd($_REQUEST['ssd']);
            $computer->setHdd($_REQUEST['hdd']);
            $computer->setCpu($_REQUEST['cpu']);
            $computer->setFila($_REQUEST['fila']);
            $computer->setColumna($_REQUEST['columna']);
            $computer->setFuentealimentacion($_REQUEST['fuentealimentacion']);
            $computer->setFechaInstalacion($_REQUEST['fechainstalacion']);
            $computer->setFechaMontaje($_REQUEST['fechamontaje']);
            setup($computer);
            break;
            
        case 'q':
            $computer = queryComputer($_REQUEST['m']);
            $computer->jsonSerialize();
            break;
            
        default:
            die('400 KO');
            
    }
    
?>