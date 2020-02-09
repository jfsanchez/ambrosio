#!/bin/bash
#
# Script de inventario e inicialización.
# Jose Sanchez. 2020. http://jfsanchez.es
#
#CONFIG_DIR='/opt/ambrosio'
CONFIG_DIR=$(pwd)
CONFIG_FILE='ambrosio.conf'
BASE_URL_QRCODE='http://...urldelcentro.../m'

mac=$(ip address|grep link/ether|awk '{print $2}')
ip=$(ip addr|grep "inet "|grep -v '127.0.0.1'|awk '{print $2}'|awk -F '/' '{print $1}')

#CPU from screenfetch
cpu=$(awk 'BEGIN{FS=":"} /model name/ { print $2; exit }' /proc/cpuinfo | awk 'BEGIN{FS=" @"; OFS="\n"} { print $1; exit }')
memoria=$(free --giga|grep Mem|awk '{print $2}')

#Solo reconoce un HDD y un SSD

hdd=''
ssd=''
for auxdisco in $(lsblk -d -o name|tail -n +2); do
	discoconcreto=$(lsblk -d -o name,rota,size|grep ${auxdisco})
	#nombredisco=$(awk 'BEGIN{split(ARGV[1],var," ");print var[1]}' ${discoconcreto})
	eshdd=$(awk 'BEGIN{split(ARGV[2],var," ");print var[1]}' ${discoconcreto})
	tamano=$(awk 'BEGIN{split(ARGV[3],var," ");print var[1]}' ${discoconcreto})
	if [[ "${eshh}" -eq "1" ]]
	then
		hdd=${tamano}
	else
		ssd=${tamano}
	fi
done

nombrehost=$(hostname)

function generarFondoLogin() {
	convert -font Ubuntu -pointsize 70 -fill white -draw "text 280,2305 '${nombrehost}. IP: ${ip}. MAC: ${mac:0:17}' " -draw "text 280,2400 '${cpu}. SSD: ${ssd}. HDD: ${hdd} '" ${CONFIG_DIR}/fondo-login.png ${CONFIG_DIR}/fondo-login-texto.png
	convert ${CONFIG_DIR}/fondo-login-texto.png -resize 1920x1080 -background "#3e534c" -gravity center -extent 1920x1080 ${CONFIG_DIR}/fondo-login-texto-1920x1080.png
	#Añadir código qr para incidencias
	qrencode -s 4 -l H -o ${CONFIG_DIR}/qrcode.png "${BASE_URL_QRCODE}/${mac:0:17}"
	convert ${CONFIG_DIR}/fondo-login-texto-1920x1080.png ${CONFIG_DIR}/qrcode.png -gravity west -composite -matte ${CONFIG_DIR}/fondo-login-texto-1920x1080-qr.jpg
	chmod 444 ${CONFIG_DIR}/fondo-login-texto-1920x1080-qr.jpg
}

function instalar() {
	mkdir -p ${CONFIG_DIR}
}

#function comprobarInstalacion() {
#	#Preguntar etiqueta y idlocalizacion
#	instalar=0
#	if [ ! -d "${CONFIG_DIR}" ] {
#		instalar=1
#	}
#	if [ ${instalar} -eq 1 ] {
#		instalar
#	}
#}

#Saber si ha sido instalado el equipo. SI: Mirar si hay cambios en IP -> No instalado o cambio IP o procesador = regenerar imagen login
#comprobarInstalacion

#¿El equipo está inventariado? Si: sacar datos etiqueta e idlocalizacion. No: pedir por pantalla

echo MAC: ${mac} IP: ${ip} CPU: ${cpu} RAM: ${memoria} GB HDD: ${hdd} SSD: ${ssd}

generarFondoLogin
