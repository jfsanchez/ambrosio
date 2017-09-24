# Ambrosio

Sistema de tickets pensado para centros.

Quedan moitas cousas por facer: Envío de emails, corrección de bugs e refactorización de partes de código. Esta é unha versión alpha.

A idea é manter un sistema moi simple, sen apenas dependencias, lixeiro e moi fácil de empregar para calquera.

## Requisitos

Ambrosio é unha aplicación web que para funcionar necesita:

* PHP
* MySQL

## Instalación

Cambiar o arquivo includes/config.php cos valores da base de datos e os propios datos do centro.

Lembra cambiar o salt por seguridade. Para xerar un novo contrasinal emprega o seguinte código PHP:

```
<?php
echo hash('sha256', 'claveSALT');
?>
```
E mete a saída do comando na táboa de usuarios, no campo "clave".

Lembra que a parte SALT é a que teñas no arquivo config.php

No futuro mellorarase a seguridade do login metendo ademáis microsegundos ao final do salt.

Importar ambrosio.sql na túa base de datos.

## Erros

Prégase notificar erros na dirección: jose (arroba) serhost punto com.
