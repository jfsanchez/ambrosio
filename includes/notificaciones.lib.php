<?php

require_once("includes/incidencias.lib.php");
// https://github.com/eoghanobrien/php-simple-mail/blob/master/class.simple_mail.php
require_once("libs/class.simple_mail.php");

function notificarIncidencia($incidencia, $notificarUsuario, $notificarGrupo){
    return false;
    $mailer = new SimpleMail();
    
//     $GLOBALS['configuraciones']['email_smtp_servidor']
//     $GLOBALS['configuraciones']['email_smtp_usuario']
//     $GLOBALS['configuraciones']['email_smtp_clave']
    
    $emailGrupo=$GLOBALS['configuraciones']['email_notification_to_'.$incidencia->idgrupo];
    $asunto=$GLOBALS['configuraciones']['email_default_subject_'.$incidencia->idgrupo];

    //Destinatarios
    $mailer->setFrom($GLOBALS['configuraciones']['email_smtp_email'], 
        $GLOBALS['configuraciones']['email_smtp_nombre']);
    $mailer->setTo($incidencia->email, $incidencia->nombre);
    if (!empty($emailGrupo)){
        $mailer->setBcc($emailGrupo);
    }
    
    $mailer->setSubject($asunto);
    $mailer->setMessage("Incidencia .... completar texto")->setHtml(); //TODO: Buscar libreria mailer
    
    $mailer->send();
    
}

?>