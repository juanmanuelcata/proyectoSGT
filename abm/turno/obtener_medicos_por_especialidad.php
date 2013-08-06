<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();



$idEspecialidad = $_POST['idEspecialidad'];
$consulta2 = 'select idmedico, nombre, apellido
                  from medico 
                  where idmedico in (select id_med
                                      from med_esp 
                                      where id_esp = "'. $idEspecialidad .'")';
$tmp = $db->query($consulta2);

foreach ($tmp as $valor){  
        echo '<option class="option1" value="'.$valor['idmedico'].'">'.$valor['nombre'].' '.$valor['apellido'].'</option>';
}
?>
 
