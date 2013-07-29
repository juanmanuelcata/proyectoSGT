 
<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();
$res = array();

    $idli = $_POST['idli'];
    $consulta2 = "DELETE FROM licencia WHERE id= '".$idli."'";
    if ($db->query($consulta2)):
      ?>
      <?php $res['resultado'] = 1; ?>
    <?php else: ?>
      <?php $res['resultado'] = 2; ?>
    <?php endif; 

echo json_encode($res);
?>