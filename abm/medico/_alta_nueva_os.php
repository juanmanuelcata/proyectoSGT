<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$nom = $_POST['nombreos'];
$medid = $_POST['idmedico'];

$consulta = "select idos from os where nombre = '$nom'";
$resul = $db->query($consulta);
$res = $resul->fetch(PDO::FETCH_ASSOC);

$idos = $res['idos'];

$arr = array();

$consulta = "insert into med_os (id_med, id_os) values ('$medid','$idos')";
if ($db->query($consulta)):
      ?>
      <?php $res['resultado'] = 1; ?>
    <?php else: ?>
      <?php $res['resultado'] = 2; ?>
    <?php endif; 

?>
