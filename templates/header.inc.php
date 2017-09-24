<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <link rel="shortcut icon" href="favicon.ico" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Aplicación de incidencias</title>
 <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css"> 
<!-- <link rel="stylesheet" href="/resources/css/main.css"> -->
 <meta http-equiv="cache-control" content="max-age=0" />
 <meta http-equiv="cache-control" content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
 <meta http-equiv="pragma" content="no-cache" />
 <meta name="robots" content="none"/>
</head>

<body>

<!-- cabecera -->
<div class="page-header">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo $instituto_nombre; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li<?php if ($BREADCRUM == "CREARINCIDENCIA") echo " class=\"active\""; ?>><a id="nuevaincidencia" data-toggle="tooltip" title="Enviar nova incidencia" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?operacion=crearincidencia";?>"><span class="glyphicon glyphicon-plus"></span> Nova incidencia</a></li>
      <?php
      if (!empty($_SESSION['usuario'])) {
        echo "<li";
        if ($BREADCRUM == "INCIDENCIAS") {
            echo " class=\"active\"";
        }
        echo "><a id=\"listado-incidencias\" data-toggle=\"tooltip\" title=\"Enlace\" href=\"?operacion=incidencias\"><span class=\"glyphicon glyphicon-list-alt\"></span> Listaxe de incidencias</a></li>";
        if ($_SESSION['esadmin'] == "1") {
            echo "<li";
            if ($BREADCRUM == "USUARIOS") {
                echo " class=\"active\"";
            }
            echo "><a data-toggle=\"tooltip\" title=\"titulo\" href=\"?operacion=usuarios\"><span class=\"glyphicon glyphicon-education\"></span> Usuarios</a></li>";
        }
      }
      ?>

	<li><div id="mensaje"></div></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <?php
      if (empty($_SESSION['usuario'])) {
          echo "<li";
          if ($BREADCRUM == "LOGIN")
              echo " class=\"active\"";
          echo "><a id=\"login\" data-toggle=\"tooltip\" title=\"Login\" href=\"?operacion=login\"><span class=\"glyphicon glyphicon-user\"></span> Acceso do mantedor</a></li>";
      }else{
          echo "<li><a id=\"logout\" data-toggle=\"tooltip\" title=\"Desconectarse\" href=\"?operacion=logout\"><span class=\"glyphicon glyphicon-log-out\"></span> Pechar sesión</a></li>";
      }
      ?>
        
        
      </ul>
    </div>
  </div>
</nav>
</div> <!--fin de la cabecera-->