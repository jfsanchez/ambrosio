<?php 

class Login {
    public $usuario;
    public $idusuario;
    public $grupos;
    public $esadmin;
    public $clave; // Solo para edición/creación
}

function login($usuario, $clave) {
    //i=entero, s=string, d=double, b=blob
    $sqlQuery="SELECT idusuario, esadmin FROM usuario WHERE usuario=? AND clave=?";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("ss", $usuario, $clave);
    $sentencia->execute();
    
    $sentencia->bind_result($idusuario, $esadmin);
    $sentencia->fetch();
    
    $sentencia->close();
    
    if (empty($idusuario)) {
        return null;
    }
    
    $usuario = new Login();
    $usuario->usuario=$usuario;
    $usuario->idusuario=$idusuario;
    $usuario->esadmin=$esadmin;
    
    $usuario->grupos=buscarGrupos($usuario->idusuario);
    //Si existe el usuario, pero no tiene permisos sobre ningún grupo, no le dejo iniciar sesion
    if (empty($usuario->grupos)){
        return null;
    }
    
    return $usuario;
}

function buscarGrupos($idUsuario){
    $sqlQuery="SELECT idgrupo FROM usuariogrupo WHERE idusuario=?";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("i", $idUsuario);
    $sentencia->execute();
    
    $sentencia->bind_result($idgrupo);

    while($sentencia->fetch()){
        $auxgrupos[]=$idgrupo;
    }

    $sentencia->close();
    
    return $auxgrupos;
}

function listarUsuariosConGrupos(){
    $sqlQuery="SELECT idusuario, usuario, esadmin FROM usuario";
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
    
    while($auxusuario = $sentencia->fetch_assoc()) {
        $usuario = new Login();
        $usuario->usuario=$auxusuario['usuario'];
        $usuario->idusuario=$auxusuario['idusuario'];
        $usuario->esadmin=$auxusuario['esadmin'];
        $usuarios[]=$usuario;
    }
    $sentencia->close();
    //Recorrer todos los usuarios y recuperar sus grupos
    for($i=0; $i < count($usuarios); $i++){
        $usuarios[$i]->grupos = buscarGrupos($usuarios[$i]->idusuario);
    }
    return $usuarios;
}

function crearUsuario($usuario){
    //Primero crear usuario
    $sqlQuery="INSERT INTO usuario(usuario, clave, esadmin) VALUES(?,?,?)";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    
    $sentencia->bind_param("ssi",$usuario->usuario, $usuario->clave, $usuario->esadmin);
    $sentencia->execute();
    
    //Comprobamos que ha insertado una fila
    if ($sentencia->affected_rows != 1) {
        return null;
    }
    
    //Cambiar idincidencia por el que nos devuelva el auto_increment
    $usuarioCreado = buscarUsuarioId($GLOBALS['mysqli']->insert_id);
    //Luego asignar permisos
    if (asignarGrupos($usuarioCreado->idusuario, $usuario->grupos) == null) {
        return null;
    }
    
    return $usuarioCreado;
}

function resetearClave($idusuario, $clavehasheada) {
    $sqlQuery="UPDATE usuario SET clave=\"".$clavehasheada."\" WHERE idusuario=".$idusuario;
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
}

function setearAdmin($idusuario, $esadmin){
    $sqlQuery="UPDATE usuario SET esadmin=".$esadmin." WHERE idusuario=".$idusuario;
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
}

function buscarUsuarioId($idusuario) {
    $sqlQuery="SELECT idusuario, usuario, esadmin FROM usuario WHERE idusuario=?";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("i", $idusuario);
    $sentencia->execute();
    
    $sentencia->bind_result($auxidusuario, $auxusuario, $auxesadmin);
    $sentencia->fetch();
    
    $sentencia->close();
    
    if (empty($idusuario)) {
        return null;
    }
    
    $usuario = new Login();
    $usuario->usuario=$auxusuario;
    $usuario->idusuario=$auxidusuario;
    $usuario->esadmin=$auxesadmin;
    
    $usuario->grupos=buscarGrupos($usuario->idusuario);
    
    return $usuario;
}

function asignarGrupos($idusuario, $grupos){
    //TODO: Asignar permisos de verdad
    $Query1= "DELETE FROM usuariogrupo where idusuario=".$idusuario;
    $GLOBALS['mysqli']->query($Query1);
    
    for($i=0; $i < count($grupos); $i++) {
        $QueryAux = "INSERT INTO usuariogrupo(idusuario, idgrupo) VALUES(".$idusuario.", ".$grupos[$i].")";
        $GLOBALS['mysqli']->query($QueryAux);
    }
    
    return 1;
}

?>