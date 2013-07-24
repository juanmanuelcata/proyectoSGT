<?php

//DETALLE PACIENTE

$db = conectaDb();
$id = $_GET['id'];

$consulta = "SELECT * FROM paciente INNER JOIN pac_os INNER JOIN os ON paciente.idpaciente =' $id ' AND pac_os.id_paciente = ' $id ' and pac_os.id_os = os.idos";
$result = $db->query($consulta);
$campos = $result->fetch(PDO::FETCH_ASSOC);
?>

<label><strong>Nombre: </strong><?php echo ($campos['nombre']) ?></label>
<br>
<label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
<br>
<label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
<br>
<label><strong>Obra Social: </strong><?php
if ($campos['activo'] == 1)
    echo '<td>' . $campos['nombre'] . '</td>';
else
    echo '<td><p style="color: #FF0000">' . $campos['nombre'] . '</p></td>';
?></label>
<br>
<label><strong>Fecha de nacimiento: </strong><?php echo ($campos['nacimiento']) ?></label>
<br>
<label><strong>Localidad: </strong><?php echo ($campos['localidad']) ?></label>
<br>
<label><strong>Calle: </strong><?php echo ($campos['calle']) ?></label>
<br>
<label><strong>Altura: </strong><?php echo ($campos['altura']) ?></label>
<br>
<label><strong>Piso: </strong><?php echo ($campos['piso']) ?></label>
<br>
<label><strong>Departamento: </strong><?php echo ($campos['depto']) ?></label>
<br>
<label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
<br>
<label><strong>Telefono: </strong><?php echo ($campos['telefono']) ?></label>
<br>
<label><strong>Ingreso: </strong><?php echo ($campos['ingreso']) ?></label>

<br>

<a href="./paciente.php?code=m&id=<?php echo ($campos['idpaciente']) ?>&os=<?php echo ($campos['os']) ?>" class="btn btn-success">Modificar</a>