<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$idEsp = $_POST['idEspecialidad'];
$consulta = 'select min(dia) dia, min(desde) desde, med_esp.id_med from especialidad inner join med_esp on (especialidad.idespecialidad = med_esp.id_esp)
            inner join horario on (med_esp.id_med = horario.id_med) where idespecialidad = ' . $idEsp . ' and horario.activo = 1';

$result = $db->query($consulta);

$res = $result->fetch(PDO::FETCH_ASSOC);

echo '<option class="option2" value="' . $res['dia'] . '">' . $res['dia'] . '</option>';
?>
