<?php

$db = conectaDb();
$id=$_GET['id'];

$consulta = "SELECT * FROM medico WHERE idmedico =' $id '";
$result = $db->query($consulta);   
$campos = $result->fetch(PDO::FETCH_ASSOC);

?>


<label style="default"><strong>Nombre: </strong><?php echo ($campos['nombre']) ?></label>
    <br>
    <label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
    <br>
    <label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
    <br>
    <label><strong>Teléfono: </strong><?php echo ($campos['telefono']) ?></label>
    <br>
    <label><strong>Matrícula: </strong><?php echo ($campos['matricula']) ?></label>
    <br>  
    <label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
    <br>
    <label><strong>Ingreso: </strong><?php echo ($campos['ingreso']) ?></label>
    <br>
    
    <a href="./medico.php?code=m&id=<?php echo ($campos['idmedico']) ?>" class="btn btn-success">Modificar</a>
