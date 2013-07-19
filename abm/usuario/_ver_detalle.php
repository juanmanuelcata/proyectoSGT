<?php

$db = conectaDb();
$id=$_GET['id'];

$consulta = "SELECT * FROM usuario WHERE idusuario =' $id '";
$result = $db->query($consulta);   
$campos = $result->fetch(PDO::FETCH_ASSOC);

?>

    <label><strong>Username: </strong><?php echo ($campos['user']) ?></label>
    <br>
    <label><strong>Nombre: </strong><?php echo ($campos['nombre']) ?></label>
    <br>
    <label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
    <br>
    <label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
    <br>
    <label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
    <br>
    
    <a href="./usuario.php?code=m&id=<?php echo ($campos['idusuario']) ?>&os=<?php echo ($campos['os']) ?>" class="btn btn-success">Modificar</a>