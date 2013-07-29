

<?php

include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
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
      
              <option class="option3" name="horario" value="<?php echo $valor['id']; ?>"><?php echo $valor['desde'];?></option>
        
      <?php  endforeach;?>

<?php endif;?>