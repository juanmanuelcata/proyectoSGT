<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();


require_once('./../../fragmentos/Dia.php');
$idmed = $_POST['idMedico'];

$consulta1 = 'select dia from horario where (id_med  = "' . $idmed . '") group by dia ';
$tmp1 = $db->query($consulta1);
$semana = array();
$i = 0;
foreach ($tmp1 as $valor1) {
  $semana[$valor1['dia']] = $valor1['dia'];
  $i++;
}

//para las licencias
$con = "select max(desde) desde, hasta, id_med from licencia where id_med = '" . $idmed . "'";
$licPdo = $db->query($con);
$lic = $licPdo->fetch(PDO::FETCH_ASSOC);
$desde = new Dia($lic['desde']);
$hasta = new Dia($lic['hasta']);
//fin para las licencias 

$consulta2 = 'select dia from horario where (id_med  = "' . $idmed . '") and (activo = 1) group by dia ';
$tmp = $db->query($consulta2);
foreach ($tmp as $valor):
  ?>
  <?php
  if (in_array($valor['dia'], $semana)):
    $aux = new Dia($valor['dia']);

    if ( $desde->getDia() <  $aux->getDia() && $aux->getDia() > $hasta->getDia()):
      ?>

      <option class="option2" name="fecha" value="<?php echo $aux->getNombre() ?>">
        <?php echo $valor['dia'] . '--' . $aux->getDia() ?></option>

      <?php unset($semana[$valor['dia']]);
    else:
      ?>
      
      <option class="option2" name="fecha" value="-1">
      <?php echo $valor['dia'] . '-Licencia-' . $aux->getDia() ?></option>
      
    <?php
    unset($semana[$valor['dia']]);
    endif;

  endif;
endforeach;
foreach ($semana as $d):
  $aux2 = new Dia($d);
  ?>

  <option class="option2" name="fecha" value="-1">
  <?php echo $d . '-Lleno-' . $aux2->getDia() ?></option>
<?php endforeach; ?>

 
