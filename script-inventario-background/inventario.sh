#!/bin/bash
#
# Script de inventario, inicialización, mantenimiento y configuración post-instalación
# Jose Sanchez. 2020. http://jfsanchez.es
#
#CONFIG_DIR='/opt/ambrosio'
CONFIG_DIR=$(pwd)
CONFIG_FILE='ambrosio.conf'
BASE_URL='https://url.del.centro'
BASE_URL_QRCODE="${BASE_URL}/m"
WS_PASSWD='clavedeambrosio'
INVENTORY_URL="${BASE_URL}/incidencias/?operacion=webservice&passwd=${WS_PASSWD}&op2=q&m="
INVENTORY_REGISTER_URL="${BASE_URL}/incidencias/"
ROOMS_URL="${BASE_URL}/incidencias/?operacion=webservice&passwd=${WS_PASSWD}&op2=l"
#Configuracion usuarios locales: invitado y administrador local
GUEST_ACCOUNT='alumno'
LOCAL_ADMIN_ACCOUNT='adminlocal'
LOCAL_ADMIN_SSHKEY=$(cat ${CONFIG_DIR}/id_rsa.pub)
HOMEDIRS="/home/DOMINIO"
HOMEDIR_DELETE_AFTER_DAYS=180
DEFAULT_DOMAIN="DOMINIO.loquesea.local"
DEFAULT_BACKTITLE="Ambrosio (c) 2020. jfsanchez.es"

mac=$(ip address|grep link/ether|awk '{print $2}')
ip=$(ip addr|grep "inet "|grep -v '127.0.0.1'|awk '{print $2}'|awk -F '/' '{print $1}')

#CPU from screenfetch
cpu=$(awk 'BEGIN{FS=":"} /model name/ { print $2; exit }' /proc/cpuinfo | awk 'BEGIN{FS=" @"; OFS="\n"} { print $1; exit }')
memoria=$(free -m|grep Mem|awk '{print $2}')

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

function resetGuestAccount() {
	rm -rf /home/${GUEST_ACCOUNT}
	cp -r /etc/skel /home/${GUEST_ACCOUNT}
	chown -R ${GUEST_ACCOUNT}.${GUEST_ACCOUNT} /home/${GUEST_ACCOUNT}
	#Cambiar clave alumno a por defecto
	echo -e "${GUEST_ACCOUNT}\n${GUEST_ACCOUNT}" | passwd ${GUEST_ACCOUNT}
}

function resetLocalAdminAccount() {
	mkdir -p /home/${LOCAL_ADMIN_ACCOUNT}/.ssh
	chown -R ${LOCAL_ADMIN_ACCOUNT}.${LOCAL_ADMIN_ACCOUNT} /home/${LOCAL_ADMIN_ACCOUNT}
	echo "${LOCAL_ADMIN_SSHKEY}" > /home/${LOCAL_ADMIN_ACCOUNT}/.ssh/authorized_keys
	chmod a-w /home/${LOCAL_ADMIN_ACCOUNT}/.ssh/authorized_keys

}

function deleteOldHomedirs() {
	find ${HOMEDIRS}/* -type d -ctime +${HOMEDIR_DELETE_AFTER_DAYS} -exec rm -rf {} \;
}

function generarFondoLogin() {
	if [[ "${ssd}" != "" ]]; then
		textoDiscos="SSD: ${ssd}"
	fi
	if [[ "${hdd}" != "" ]]; then
		textoDiscos="${textoDiscos} HDD: ${hdd}"
	fi

	rm -f ${CONFIG_DIR}/fondo-login-texto-1920x1080-qr.jpg
	convert -font Ubuntu -pointsize 70 -fill white -draw "text 280,2305 '${nombrehost}. MAC: ${mac:0:17}' " -draw "text 280,2400 '${cpu}. RAM: ${memoria} MiB. ${textoDiscos} '" ${CONFIG_DIR}/fondo-login.png ${CONFIG_DIR}/fondo-login-texto.png
	convert ${CONFIG_DIR}/fondo-login-texto.png -resize 1920x1080 -background "#3e534c" -gravity center -extent 1920x1080 ${CONFIG_DIR}/fondo-login-texto-1920x1080.png
	rm -f ${CONFIG_DIR}/fondo-login-texto.png
	#Añadir código qr para incidencias
	qrencode -s 4 -l H -o ${CONFIG_DIR}/qrcode.png "${BASE_URL_QRCODE}/${mac:0:17}"
	convert ${CONFIG_DIR}/qrcode.png -resize 330x200 -background "#3e534c" -gravity northeast -extent 330x200 ${CONFIG_DIR}/qrcode-resized.png
	rm -f ${CONFIG_DIR}/qrcode.png
	convert ${CONFIG_DIR}/fondo-login-texto-1920x1080.png ${CONFIG_DIR}/qrcode-resized.png -gravity west -composite -matte ${CONFIG_DIR}/fondo-login-texto-1920x1080-qr.jpg
	chmod 444 ${CONFIG_DIR}/fondo-login-texto-1920x1080-qr.jpg
	rm -f ${CONFIG_DIR}/fondo-login-texto-1920x1080.png
	rm -f ${CONFIG_DIR}/qrcode-resized.png
}

function comprobarInstalacion() {
	comprobarInstalacion=0
	if [ -f "${CONFIG_DIR}/${CONFIG_FILE}" ]; then
		if [[ "${mac}" != $(cat ${CONFIG_DIR}/${CONFIG_FILE}) ]]; then
			comprobarInstalacion=1
		fi
	else
		mkdir -p ${CONFIG_DIR}
		comprobarInstalacion=1
	fi
}

function instalar() {

	configuraciones=$(curl ${INVENTORY_URL}${mac} 2> /dev/null)
	OLDIFS=$IFS
	IFS=$'\n'

	#echo  ${configuraciones}
cr='
'
	for conf in ${configuraciones//\\n/$cr}
	do
		#echo $conf
		if [ "${conf}" == "403 ERROR" ]; then
			echo Clave incorrecta, imposible instalar
			IFS=$OLDIFS
			exit;
		else
			#echo nombre $nombre\n valor $valor
			nombre=$(echo $conf|awk -F '=' '{print $1}')
			valor=$(echo $conf|awk -F '=' '{print $2}')
			eval aux_${nombre}=\"${valor}\"
			echo aux_${nombre} \"${valor}\"
		fi

	done

	IFS=${OLDIFS}

	#echo ${datos}

	#--read -p "Texto: " variableTexto
	exec 3>&1;
	new_fila=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "POSICION DEL EQUIPO" --inputbox "Indica el número o nombre de la FILA donde esta el ordenador:" 8 40 ${aux_fila} 2>&1 1>&3)
	new_columna=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "POSICION DEL EQUIPO" --inputbox "Indica la posición dentro de la fila (COLUMNA):" 8 40 ${aux_columna} 2>&1 1>&3)
	new_etiqueta=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "ETIQUETA DEL EQUIPO" --inputbox "Nombre que aparece en la etiqueta\n(número de equipo):" 8 50 "${aux_etiqueta}" 2>&1 1>&3)
	new_dns=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "NOMBRE DEL EQUIPO" --inputbox "Nombre DNS completo del equipo (con el dominio):" 8 60 "${aux_dns}" 2>&1 1>&3)
	new_dominio=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "UNIRSE A UN DOMINIO" --inputbox "Dominio al que unirse:" 8 70 ${DEFAULT_DOMAIN} 2>&1 1>&3)
	new_dominio_usuario=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "UNIRSE A UN DOMINIO" --inputbox "Usuario del dominio:" 8 70 administrador 2>&1 1>&3)
	new_boca=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "BOCA DE RED" --inputbox "Indica el nombre de la boca de red a donde va conectado:" 8 40 ${aux_boca} 2>&1 1>&3)
	new_fuentealimentacion=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "Fuente de alimentación" --inputbox "Indica la marca y potencia (u otros datos relevantes) de la fuente de alimentacion:" 8 40 ${aux_fuentealimentacion} 2>&1 1>&3)
	###new_dominio_clave=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "UNIRSE A UN DOMINIO" --clear --passwordbox "Clave del dominio (no se mostrará):" 8 70 2>&1 1>&3)

	new_fecha_montaje=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "FECHA DE ENSAMBLADO O COMPRA DE PIEZAS" --calendar "Seleccione fecha de ensamblado del equipo (por garantía de piezas)" 5 80 $(date +'%d') $(date +'%m') $(date +'%Y') 2>&1 1>&3)
	new_fecha_instalacion=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "FECHA DE INSTALACIÓN" --calendar "Fecha de instalación del equipo (debería se rhoy)" 5 80 $(date +'%d') $(date +'%m') $(date +'%Y') 2>&1 1>&3)
	listaLocalizaciones=$(curl $ROOMS_URL 2> /dev/null)
	new_ubicacion=$(dialog --backtitle "${DEFAULT_BACKTITLE}" --title "UBICACIÓN DEL EQUIPO" --menu "Indique en donde está el equipo" 23 80 17 ${listaLocalizaciones} 2>&1 1>&3)
	exec 3>&-;

	subdominio=$(echo ${new_dns}|awk -F '.' '{print $1}')
	echo Enviando datos de instalación a servicio web...
	#Ajustar fechas
	new_fecha_montaje=$(echo ${new_fecha_montaje}|awk -F '/' '{printf("%s/%s/%s", $3, $2, $1)}')
	new_fecha_instalacion=$(echo ${new_fecha_instalacion}|awk -F '/' '{printf("%s/%s/%s", $3, $2, $1)}')
	fechamontaje_procesada=$(echo ${new_fecha_montaje} 00:00:00|tr / -)
	fechainstalacion_procesada=$(echo ${new_fecha_instalacion} 00:00:00|tr / -)

	curl -G -v ${INVENTORY_REGISTER_URL} --data-urlencode "operacion=webservice" --data-urlencode "passwd=${WS_PASSWD}" --data-urlencode "op2=s" --data-urlencode "idlocalizacion=${new_ubicacion}" --data-urlencode "etiqueta=${new_etiqueta}" --data-urlencode "mac=${mac}" --data-urlencode "ip=${ip}" --data-urlencode "dns=${new_dns}" --data-urlencode "boca=${new_boca}" --data-urlencode "ram=${memoria}" --data-urlencode "ssd=${ssd}" --data-urlencode "hdd=${hdd}" --data-urlencode "cpu=${cpu}" --data-urlencode "fila=${new_fila}" --data-urlencode "columna=${new_columna}" --data-urlencode "fuentealimentacion=${new_fuentealimentacion}" --data-urlencode "fechainstalacion=${fechainstalacion_procesada}" --data-urlencode "fechamontaje=${fechamontaje_procesada}"

	#echo Dejando el dominio anterior...
	#/usr/bin/pbis leave
	#echo Ajustando hostname del PC a: ${subdominio}
	#hostname ${subdominio}
	#hostname=${subdominio}
	#sed -i 's|pcubuntuZ|${subdominio}|g' /etc/hostname
	#sed -i 's|pcubuntuZ|${subdominio}|g' /etc/hosts
	#echo Uniendo a nuevo dominio... (por favor teclee la clave del usuario que ha indicado cuando se le pida)
	#/usr/bin/pbis join ${new_dominio} ${new_dominio_usuario}


}
case "$1" in
	generarPantallaLogin)
		generarFondoLogin
	;;

	resetAdminAccount)
		resetLocalAdminAccount
	;;

	initGuestAccount)
		resetGuestAccount
	;;

	*)
		echo Información del equipo: MAC: ${mac} IP: ${ip} CPU: ${cpu} RAM: ${memoria} GB HDD: ${hdd} SSD: ${ssd}
		#Saber si ha sido instalado el equipo. SI: Mirar si hay cambios en MAC -> No instalado = regenerar imagen login
		comprobarInstalacion
		if [[ ${comprobarInstalacion} == "1" ]]; then
			echo Generando pantalla de login...
			generarFondoLogin
			echo Instalando y registrando...
			instalar
			echo ${mac} > ${CONFIG_DIR}/${CONFIG_FILE}
		fi

esac

exit 0


