 
<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();
$res = array();

if (isset($_POST['ok'])) {
  if ($_POST['ok'] == 1) {
    $idturno = $_POST['idturno'];
    $consulta2 = 'UPDATE turno SET estado = "confirmado" WHERE idturno = "' . $idturno . '"';
    if ($db->query($consulta2)):
      ?>
      <?php $res['resultado'] = 1; ?>
    <?php else: ?>
      <?php $res['resultado'] = 2; ?>
    <?php endif; ?>

  <?php
  }else {
    $idturno = $_POST['idturno'];
    $consulta2 = 'UPDATE turno SET estado = "cancelado" WHERE idturno = "' . $idturno . '"';
    if ($db->query($consulta2)): ?>
      <?php $res['resultado'] = 3; ?>
    <?php else: ?>
      <?php $res['resultado'] = 4; ?>
    <?php endif;
  }
  $idhorario = $_POST['idhorario'];
   $consulta2 = 'UPDATE horario SET activo = 1 WHERE id = "' . $idhorario . '"';
   if ($db->query($consulta2)){
     $res['resultado'] = 5;
     
   }else{
   $res['resultado'] = 6;
     
   };
} 

echo json_encode($res);
?>
  

