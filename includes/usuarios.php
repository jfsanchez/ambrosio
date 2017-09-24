<?php

define("PLANTILLA", "usuarios");

require_once("includes/login.lib.php");

switch ($_POST['operacion2']){
    case 'crear':
    creacionUsuario();
    break;
    
    case 'editar':
    edicionUsuario();
    break;
    
    default:
}

//recuperar ids ($_POST['idgrupo de cada grupo de todos los de la bd']

$usuarios = listarUsuariosConGrupos();

//TODO: Resetear clave, cambiar permisos 
function edicionUsuario() {
    
    //Si la clave tiene algo, hay que cambiarla
    if (!empty($_POST['clave'])){
        $clave=hashearClave($_POST['clave']);
        resetearClave($_POST['idusuario'], $clave);
    }
    
    //Opción admin a mayores
    $esadmin=0;
    if ($_POST['esadmin'] == true){
        $esadmin=1;
    }
    setearAdmin($_POST['idusuario'], $esadmin);
    
    foreach ($GLOBALS['grupos'] as $id => $nombre){
        if ($_POST[$id] == true){
            $accesogrupos[]=$id;
        }
    }
    
    //Comprobar si es administrador
    

//     for($i=0; $i < count($GLOBALS['grupos']); $i++){
//         if ($_POST[$GLOBALS['grupos'][$i]] == true) {
//             $accesogrupos[]=$GLOBALS['grupos'][$i];
//         }
//     }
    
    //Coger lista de grupos y editar los permisos
    asignarGrupos($_POST['idusuario'], $accesogrupos);
    header("Location: index.php?operacion=usuarios");
    die();
}

function creacionUsuario(){
    $usuario = $_POST['usuario'];
    //$clave = hash('sha256', $_REQUEST['clave'].$GLOBALS['salt']);
    $clave=hashearClave($_REQUEST['clave']);
    
    foreach ($grupos as $idgrupo => $nombregrupo){
        if ($_POST[$idgrupo] == true){
            $grupospermitidos[]=$idgrupo;
        }
    }
    $auxUsuario = new Login();
    if ($_POST['esadmin'] == true) {
        $auxUsuario->esadmin=1;
    }
    $auxUsuario->grupos=$grupospermitidos;
    $auxUsuario->usuario=$usuario;
    $auxUsuario->clave=$clave;
    crearUsuario($auxUsuario);
}

function hashearClave($clave){
    return hash('sha256', $clave.$GLOBALS['salt']);
}

require("templates/generalweb.inc.php");
?>