<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();



$dia = $_POST['dia'];
$med = $_POST['med'];
$consulta2 = 'select * from horario where (id_med  = "'. $med .'") and (dia = "'.$dia.'") and (activo = 1)' ;
$tmp = $db->query($consulta2);

foreach ($tmp as $valor){  
  echo '<option class="option3" name="horario" value="'.$valor['id'].'">'.$valor['desde'].'</option>';
}

?>

  
