<?php
class Incidencia{
    public $idincidencia;
    public $fechaCreacion;
    public $nombre;
    public $email;
    public $urgencia;
    public $idlocalizacion;
    public $mensaje;
    public $fechaResolucion;
    public $idestado;
    public $idgrupo;
    public $tokenweb;
}

class ComentarioIncidencia{
    public $idrespuesta, $idincidencia, $fechaHora, $idusuario, $usuario, $texto, $idestado, $estado, $publica;
}

function crearIncidencia($incidencia){
    //i=entero, s=string, d=double, b=blob
    $sqlQuery="INSERT INTO incidencia (nombre, email, urgencia, idlocalizacion, ".
                "mensaje, idestado, idgrupo, tokenweb) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("ssiisiis", $incidencia->nombre, $incidencia->email,
        $incidencia->urgencia, $incidencia->idlocalizacion, $incidencia->mensaje,
        $incidencia->idestado, $incidencia->idgrupo, $incidencia->tokenweb);
    $sentencia->execute();
    
    //Comprobamos que ha insertado una fila
    if ($sentencia->affected_rows != 1) {
        return null;
    }
    
    //Cambiar idincidencia por el que nos devuelva el auto_increment
    $incidencia = buscarIncidenciaId($GLOBALS['mysqli']->insert_id);
    
    return $incidencia;
}

function buscarIncidenciaId($idIncidencia){
    //Por no hacer un prepareStatement
    if (!is_numeric($idIncidencia)){
        return null;
    }
    $sqlQuery="SELECT idincidencia, fechacreacion, nombre, email, urgencia, ".
    "idlocalizacion, mensaje, fecharesolucion, idestado, idgrupo, tokenweb FROM incidencia ".
    "WHERE idincidencia = ". $idIncidencia;
    
    $auxResult = $GLOBALS['mysqli']->query($sqlQuery);
    $auxIncidencia = $auxResult->fetch_assoc();
    $incidencia = new Incidencia();
    $incidencia->email=$auxIncidencia['email'];
    $incidencia->fechaCreacion=$auxIncidencia['fechaCreacion'];
    $incidencia->fechaResolucion=$auxIncidencia['fechaResolucion'];
    $incidencia->idestado=$auxIncidencia['idestado'];
    $incidencia->idgrupo=$auxIncidencia['idgrupo'];
    $incidencia->idincidencia=$auxIncidencia['idincidencia'];
    $incidencia->idlocalizacion=$auxIncidencia['idlocalizacion'];
    $incidencia->mensaje=$auxIncidencia['mensaje'];
    $incidencia->nombre=$auxIncidencia['nombre'];
    $incidencia->urgencia=$auxIncidencia['urgencia'];
    $incidencia->tokenweb=$auxIncidencia['tokenweb'];
    
    $auxResult->close();
    return $incidencia;
}

function buscarIncidencias($idgrupo, $idestado){
    $idestado=tratarDato($idestado);
    $idgrupo=tratarDato($idgrupo);
    if (!is_numeric($idgrupo)){
        return null;
    }
    if (!is_numeric($idestado)){
        return null;
    }
    $sqlQuery="SELECT idincidencia, fechacreacion, nombre, email, urgencia, ".
        "idlocalizacion, mensaje, fecharesolucion, idestado, idgrupo, tokenweb ".
        "FROM incidencia WHERE idgrupo=".$idgrupo." AND idestado=".$idestado;
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
    while ($auxIncidencia= $sentencia->fetch_assoc()) {
        $incidencia = new Incidencia();
        $incidencia->email=$auxIncidencia['email'];
        $incidencia->fechaCreacion=$auxIncidencia['fechacreacion'];
        $incidencia->fechaResolucion=$auxIncidencia['fechaResolucion'];
        $incidencia->idestado=$auxIncidencia['idestado'];
        $incidencia->idgrupo=$auxIncidencia['idgrupo'];
        $incidencia->idincidencia=$auxIncidencia['idincidencia'];
        $incidencia->idlocalizacion=$auxIncidencia['idlocalizacion'];
        $incidencia->mensaje=$auxIncidencia['mensaje'];
        $incidencia->nombre=$auxIncidencia['nombre'];
        $incidencia->urgencia=$auxIncidencia['urgencia'];
        $incidencia->tokenweb=$auxIncidencia['tokenweb'];
        $incidencias[]=$incidencia;
    }
    return $incidencias;
}

function cambiarEstado($idincidencia, $idnuevoestado, $idgrupo){
    //Si, debería devolver el número de tuplas afectadas
    if (!is_numeric($idincidencia) || !is_numeric($idnuevoestado) || !is_numeric($idgrupo)){
        return null;
    }
    $sqlQuery="UPDATE incidencia SET idestado=".$idnuevoestado.", idgrupo=".$idgrupo." WHERE idincidencia=".$idincidencia;
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
    return true;
}

//TODO: IMPORTANTE, buscar comentario de cada incidencia y mostrarlo en la tabla: texto y debajo que usuario lo escribio y cuando
function buscarComentarios($idincidencia){
    $sqlQuery = "SELECT ri.idrespuesta, ri.idincidencia, ri.fechaHora, ri.idusuario,".
        "u.usuario, ri.texto, ri.idestado, e.nombre as estado, ri.publica ".
        "FROM respuestaincidencia ri, usuario u, estado e ".
        "WHERE ri.idusuario=u.idusuario AND e.idestado=ri.idestado AND ri.idincidencia=? ".
        "ORDER BY idincidencia, fechaHora";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("i", $idincidencia);
    $sentencia->execute();
    
    $sentencia->bind_result($idrespuesta, $idincidencia, $fechaHora, $idusuario, $usuario, $texto, $idestado, $estado, $publica);
    
    while ($sentencia->fetch()) {
        $aux = new ComentarioIncidencia();
        $aux->estado=$estado;
        $aux->fechaHora=$fechaHora;
        $aux->idestado=$idestado;
        $aux->idincidencia=$idincidencia;
        $aux->idrespuesta=$idrespuesta;
        $aux->idusuario=$idusuario;
        $aux->publica=$publica;
        $aux->texto=$texto;
        $aux->usuario=$usuario;
        $comentarios[]=$aux;
    }
    
    $sentencia->close();
    return $comentarios;
}

function insertarComentario($idincidencia, $idusuario, $texto, $idestado, $publica){
    if ($publica){
        $publica=1;
    } else{
        $publica=0;
    }
    $sqlQuery="INSERT INTO respuestaincidencia(idincidencia, idusuario, texto, idestado, publica) VALUES(?,?,?,?,?)";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("iisii", $idincidencia, $idusuario, $texto, $idestado, $publica);
    echo $idincidencia.",".$idusuario.",".$texto.",".$idestado.",". $publica;
    $sentencia->execute();
    
    //Comprobamos que ha insertado una fila
    if ($sentencia->affected_rows != 1) {
        return null;
    }
    
    //devolver id del comentario
    return $GLOBALS['mysqli']->insert_id;
    
}

function contarNuevasIncidencias($idestado) {
    if (!is_numeric($idestado)){
        return null;
    }
    $sqlQuery="SELECT idgrupo, count(*) FROM incidencia WHERE idestado=".$idestado." GROUP BY idgrupo";
    $sentencia = $GLOBALS['mysqli']->query($sqlQuery);
    while ($aux = $sentencia->fetch_row()) {
        $estadisticas[$aux[0]]=$aux[1];
    }
    $sentencia->close();
    
    return $estadisticas;
}

?>