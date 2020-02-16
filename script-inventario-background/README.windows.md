# Apuntes PowerShell para coger variables del sistema interesantes para inventario simple:

## Unirse a dominio:
Add-computer -DomainName "your.ADDomainToJoin.net" -Credential LoginWithJoinPermissions 

## Salir del dominio:
Remove-computer -WorkgroupName yourWorkgroup 

## Saber usuario actual:
$env:UserName

## Todas las mac de las tarjetas de red:
Get-CimInstance win32_networkadapterconfiguration | select description, macaddress 

## Procesador:
Get-WmiObject Win32_Processor

## RAM:
Get-WmiObject -Class Win32_ComputerSystem | select TotalPhysicalMemory

Existe cURL para enviar datos.

Este texto es para un posible futuro de script de instalación para Windows
