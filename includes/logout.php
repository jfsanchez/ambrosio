<?php 
$_SESSION['usuario']="";
$_SESSION['idusuario']="";
$_SESSION['grupos']="";
$_SESSION['esadmin']="";
session_destroy();
session_abort();
header("Location: ?op=crearincidencia");
?>