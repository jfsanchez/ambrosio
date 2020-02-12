<?php

class Computer {
    private $idordenador, $idlocalizacion, $etiqueta;
    private $mac, $ip, $dns, $boca;
    private $ram, $ssd, $hdd, $cpu;
    private $fila, $columna, $fuentealimentacion;
    private $fechaInstalacion, $fechaMontaje;
    
    //Cambiada por comodidad para parsear de modo simple desde bash
    public function jsonSerialize() {
        echo
        //'<pre>'."\n".
        'idordenador='.$this->getIdordenador()."\n".
        'idlocalizacion='.$this->getIdlocalizacion()."\n".
        'etiqueta='.$this->getEtiqueta()."\n".
        'mac='. $this->getMac()."\n".
        'ip='. $this->getIp()."\n".
        'dns='. $this->getDns()."\n".
        'boca='. $this->getBoca()."\n".
        'ram='. $this->getRam()."\n".
        'ssd='.$this->getSsd()."\n".
        'hdd='. $this->getHdd()."\n".
        'cpu='.$this->getCpu()."\n".
        'fuentealimentacion='.$this->getFuentealimentacion()."\n".
        'fechaInstalacion='.$this->getFechaInstalacion()."\n".
        'fechaMontaje='.$this->getFechaMontaje()
        ;
    }
    
    /**
     * @return mixed
     */
    public function getIdordenador()
    {
        return $this->idordenador;
    }
    
    /**
     * @return mixed
     */
    public function getIdlocalizacion()
    {
        return $this->idlocalizacion;
    }
    
    /**
     * @return mixed
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }
    
    /**
     * @return mixed
     */
    public function getMac()
    {
        return $this->mac;
    }
    
    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }
    
    /**
     * @return mixed
     */
    public function getDns()
    {
        return $this->dns;
    }
    
    /**
     * @return mixed
     */
    public function getBoca()
    {
        return $this->boca;
    }
    
    /**
     * @return mixed
     */
    public function getRam()
    {
        return $this->ram;
    }
    
    /**
     * @return mixed
     */
    public function getSsd()
    {
        return $this->ssd;
    }
    
    /**
     * @return mixed
     */
    public function getHdd()
    {
        return $this->hdd;
    }
    
    /**
     * @return mixed
     */
    public function getCpu()
    {
        return $this->cpu;
    }
    
    /**
     * @return mixed
     */
    public function getFila()
    {
        return $this->fila;
    }
    
    /**
     * @return mixed
     */
    public function getColumna()
    {
        return $this->columna;
    }
    
    /**
     * @return mixed
     */
    public function getFuentealimentacion()
    {
        return $this->fuentealimentacion;
    }
    
    /**
     * @return mixed
     */
    public function getFechaInstalacion()
    {
        return $this->fechaInstalacion;
    }
    
    /**
     * @return mixed
     */
    public function getFechaMontaje()
    {
        return $this->fechaMontaje;
    }
    
    /**
     * @param mixed $idordenador
     */
    public function setIdordenador($idordenador)
    {
        $this->idordenador = $idordenador;
    }
    
    /**
     * @param mixed $idlocalizacion
     */
    public function setIdlocalizacion($idlocalizacion)
    {
        $this->idlocalizacion = $idlocalizacion;
    }
    
    /**
     * @param mixed $etiqueta
     */
    public function setEtiqueta($etiqueta)
    {
        $this->etiqueta = $etiqueta;
    }
    
    /**
     * @param mixed $mac
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
    }
    
    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }
    
    /**
     * @param mixed $dns
     */
    public function setDns($dns)
    {
        $this->dns = $dns;
    }
    
    /**
     * @param mixed $boca
     */
    public function setBoca($boca)
    {
        $this->boca = $boca;
    }
    
    /**
     * @param mixed $ram
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
    }
    
    /**
     * @param mixed $ssd
     */
    public function setSsd($ssd)
    {
        $this->ssd = $ssd;
    }
    
    /**
     * @param mixed $hdd
     */
    public function setHdd($hdd)
    {
        $this->hdd = $hdd;
    }
    
    /**
     * @param mixed $cpu
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
    }
    
    /**
     * @param mixed $fila
     */
    public function setFila($fila)
    {
        $this->fila = $fila;
    }
    
    /**
     * @param mixed $columna
     */
    public function setColumna($columna)
    {
        $this->columna = $columna;
    }
    
    /**
     * @param mixed $fuentealimentacion
     */
    public function setFuentealimentacion($fuentealimentacion)
    {
        $this->fuentealimentacion = $fuentealimentacion;
    }
    
    /**
     * @param mixed $fechaInstalacion
     */
    public function setFechaInstalacion($fechaInstalacion)
    {
        $this->fechaInstalacion = $fechaInstalacion;
    }
    
    /**
     * @param mixed $fechaMontaje
     */
    public function setFechaMontaje($fechaMontaje)
    {
        $this->fechaMontaje = $fechaMontaje;
    }
}

//Devuelve la fila del ultimo ordenador instalado
function queryComputer($mac) {
    $sqlQuery = "SELECT idordenador, idlocalizacion, etiqueta, boca, mac, dns, ip, ".
        "procesador, ssd, hdd, ram, fila, columna, fuentealimentacion, fechaInstalacion, fechaMontaje ".
        "FROM ordenador WHERE mac=? ORDER BY idordenador DESC LIMIT 0, 1";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $sentencia->bind_param("s", $mac);
    $sentencia->execute();
    
    $sentencia->bind_result($idordenador, $idlocalizacion, $etiqueta, $boca, $mac, $dns, $ip,
        $procesador, $ssd, $hdd, $ram, $fila, $columna, $fuentealimentacion, $fechaInstalacion, $fechaMontaje);
    
    $sentencia->fetch();
    
    $computer = new Computer;
    $computer->setIdordenador($idordenador);
    $computer->setIdLocalizacion($idlocalizacion);
    $computer->setEtiqueta($etiqueta);
    $computer->setBoca($boca);
    $computer->setMac($mac);
    $computer->setDns($dns);
    $computer->setIp($ip);
    $computer->setCpu($procesador);
    $computer->setSsd($ssd);
    $computer->setHdd($hdd);
    $computer->setRam($ram);
    $computer->setFila($fila);
    $computer->setColumna($columna);
    $computer->setFuentealimentacion($fuentealimentacion);
    $computer->setFechaInstalacion($fechaInstalacion);
    $computer->setFechaMontaje($fechaMontaje);
    
    $sentencia->close();
    return $computer;
    
}

//Instalar un ordenador y hacer inventario (actualizar datos)
function setup($computer) {
    $sqlQuery="INSERT INTO ordenador(idlocalizacion, etiqueta, boca, mac, dns, ip, ".
        "procesador, ssd, hdd, ram, fila, columna, fuentealimentacion, fechaInstalacion, fechaMontaje) ".
        "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    $computer= new Computer; // Borrar esta linea
    
    $sentencia->bind_param("isssssssssiiss", $computer->getIdLocalizacion, $computer->getEtiqueta, $computer->getBoca(),
        $computer->getMac(), $computer->getDns(), $computer->getIp(), $computer->getCpu(), $computer->getSsd(),
        $computer->getHdd(), $computer->getRam(), $computer->getFila(), $computer->getColumna(), $computer->getFuentealimentacion(),
        $computer->getFechaInstalacion(), $computer->getFechaMontaje() );
    
    $sentencia->execute();
    
    //Comprobamos que ha insertado una fila
    if ($sentencia->affected_rows != 1) {
        echo "ERRROR";
    }
    
    //devolver id del comentario
    echo "OK. ID: ". $GLOBALS['mysqli']->insert_id;
    
    $sentencia->close();
}

function RoomList() {
    $sqlQuery="SELECT idlocalizacion, nombreaula FROM localizaciones";
    $sentencia = $GLOBALS['mysqli']->prepare($sqlQuery);
    
    $sentencia->execute();
    
    $sentencia->bind_result($idlocalizacion, $nombreaula);
    
    while ($sentencia->fetch()) {
	echo $idlocalizacion . " '" . str_replace(" ", "_", $nombreaula) . "' ";
    }
    $sentencia->close();
}
?>
