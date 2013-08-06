

<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
require_once('./../../fragmentos/Dia.php');
$db = conectaDb();
$dia = $_POST['dia'];
$med = $_POST['med'];
$consulta2 = 'select * from horario where (id_med  = "'. $med .'") and (dia = "'.$dia.'") and (activo = 1)' ;
$tmp = $db->query($consulta2);?>

<?php if($tmp->rowCount() == 0):?>

      <option value="-1" class="option3">No hay horarios libres</option>

<?php else: ?>

      <option value="-1" class="option3" selected="selected">Seleccione un horario</option>
      
      <?php foreach ($tmp as $valor):?>
              <?php $diahoy = new Dia(date('d-m-Y'));
                    $nomdia= $diahoy->getNombre();?>
              <?php if($nomdia == $dia):?>
                   <?php $ahora = strftime("%X", strtotime(date('H:m:s')));
                          $hora = strftime("%X", strtotime($valor['desde']));?>
                     <?php if($hora > $ahora):?>
                        <option class="option3" name="horario" value="<?php echo $valor['id']; ?>"><?php echo $valor['desde'];?></option>
                    <?php endif;?>
               <?php else:?>
                      <option class="option3" name="horario" value="<?php echo $valor['id']; ?>"><?php echo $valor['desde'];?></option>  
              <?php endif;?>
                      
      <?php  endforeach;?>

<?php endif;?>
