<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();


require_once('../../fragmentos/Dia.php');
$idmed = $_POST['idMedico'];
$consulta2 = 'select dia from horario where (id_med  = "'. $idmed .'") and (activo = 1) group by dia' ;
$tmp = $db->query($consulta2);
foreach ($tmp as $valor){  
 $aux = new Dia($valor['dia']);
 echo '<option class="option2" name="fecha" value="' .$aux->getNombre(). '">' . $valor['dia'] .'--'.$aux->getDia(). '</option>';
}
?>
 
