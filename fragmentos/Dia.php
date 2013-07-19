<?php

class Dia {

  var $semana = array("dom" => "0", "lun" => "1", "mar" => "2", "mie" => "3", "jue" => "4", "vie" => "5", "sab" => "6");
  var $nombre;
  var $dia;

  //crea el objeto dia con el atributo del fecha actual y nombre
  function __construct() {
    //entre sin parametros
    if (func_num_args() == 0) {
      $this->setDia(date('d-m-Y'));
      $this->calcDia($this->dia);
    } else {
      //parametro como fecha (dd-mm-aaaa)
      if (strlen(func_get_arg(0)) != 3) {
          $this->setDia(func_get_arg(0));
          $this->setNombre(func_get_arg(0));
      } else {
        if (strlen(func_get_arg(0)) == 3) {
        //entro con nombre corto de 3 letras "lun", "mar", "mie" etc
          $f = $this->calcFecha(func_get_arg(0));
          $this->dia=$f;
          $this->nombre=func_get_arg(0);
        }        
      }
    }
  }
//devuelve la fecha del dia dado un nombre (dentro de los proximos 7 dias
  function calcFecha($d) {
    $hoy = $this->calcDia(date('d-m-Y'));
    if ($this->semana[$d] > $this->semana[$hoy])
      $prox = date('d-m-Y', strtotime('+' . $this->semana[$d] - $this->semana[$hoy] . ' day'));
    else
      $prox = date('d-m-Y', strtotime('+' . $this->semana[$d] + $this->semana[$hoy] - 1 . ' day'));
    return $prox;
  }

  //devuelve el nombre del dia dada una fecha (d-m-Y)
  public function calcDia($fecha) {
    $fech = strtotime($fecha); //pasamos a timestamp 
    //el parametro w en la funcion date indica que queremos el dia de la semana 
    //lo devuelve en numero 0 domingo, 1 lunes,.... 
    switch (date('w', $fech)) {
      case 0: $this->nombre = "dom";
        break;
      case 1: $this->nombre = "lun";
        break;
      case 2: $this->nombre = "mar";
        break;
      case 3: $this->nombre = "mie";
        break;
      case 4: $this->nombre = "jue";
        break;
      case 5: $this->nombre = "vie";
        break;
      case 6: $this->nombre = "sab";
        break;
    }
    return $this->nombre;
  }

  public function calcProxDia($d) {
    if ($this->semana[$d] > $this->semana[$this->nombre])
      $prox = date('d-m-Y', strtotime('+' . $this->semana[$d] - $this->semana[$this->nombre] . ' day'));
    else
      $prox = date('d-m-Y', strtotime('+' . $this->semana[$d] + $this->semana[$this->nombre] - 1 . ' day'));
    $otroDia = new Dia($prox);
    return $otroDia;
  }

  public function setDia($q) {
    $this->dia = $q;
  }

  public function getDia() {
    return $this->dia;
  }

  public function getNombre() {
    return $this->nombre;
  }
  public function setNombre($p){
    $this->nombre = $this->calcDia($p);
  }

}

?>
