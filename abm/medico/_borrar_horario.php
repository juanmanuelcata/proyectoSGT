<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$dia = $_POST['dia'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$id = $_POST['medicoid'];

$d = date_create($desde);

$cant = $hasta - $desde;
$inter = new DateInterval('PT30M');

for ($f = 1; $f <= $cant * 2; $f++) {
    $t = date_format($d, "H:i:s");
    $borrarHorario = "delete from horario where dia = '".$dia."' and desde='$t' and id_med = '$id'";
    
    $d->add($inter);
    
    $db->query($borrarHorario);
}

?>
