<?php
include_once './_conectDb.php';
$db = conectaDb();
require_once('./Dia.php');
$hoy = new Dia();
$consulta = "update horario set activo=1 where dia = '".$hoy->getNombre()."' and activo = 0";
echo $consulta;

if($db->query($consulta))
  echo "todo bien";
else
  echo "todo mal";


?>
