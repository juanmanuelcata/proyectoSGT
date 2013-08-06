<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$nom = $_POST['nombreos'];
$medid = $_POST['medicoid'];

$consulta = "select idos from os where nombre = '$nom'";
$resul = $db->query($consulta);
$res = $resul->fetch(PDO::FETCH_ASSOC);

$idos = $res['idos'];

$consulta2 = 'delete from med_os where id_os = '.$idos.' and id_med = '.$medid.'';
$db->query($consulta2);

?>
