<?php
require_once("includes/config.php");
global $mysqli;
$mysqli = new mysqli($sql_host, $sql_usuario, $sql_clave, $sql_nombre_bd);
if (mysqli_connect_errno($mysqli)) {
    die( "Fallo al conectar a MySQL: " . mysqli_connect_error());
}
$mysqli->set_charset("utf8");
?>
